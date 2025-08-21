<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use App\Notifications\LowAttendanceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendancesController extends Controller
{
    public function markAttendance(Request $request)
    {


        $attendances = Attendance::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'date' => $request->date ?? now(),
            'status' => $request->status,
        ]);
        return response()->json([
            'message' => 'Attendances Marked',
            'attendances' => $attendances
        ], 201);
    }

    public function studentAttendance($id, Request $request)
    {
        $query = Attendance::where('student_id', $id)->with('course');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $records = $query->orderBy('date', 'desc')->get();

        return response()->json($records, 200);
    }


    public function courseAttendance($id)
    {
        $records = Attendance::where('course_id', $id)
            ->with('student')
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($records, 200);
    }

    public function studentReport($studentId, $courseId)
    {
        $attendances = Attendance::where('student_id', $studentId)->where('course_id', $courseId)->get();

        $total = $attendances->count();
        $present = $attendances->where('status', 'present')->count();
        $absent = $attendances->where('status', 'absent')->count();
        $late = $attendances->where('status', 'late')->count();

        $percantage = $total > 0 ? round(num: ($present / $total) * 100, precision: 2) : 0;

        if ($percantage < 70) {
    $student = Student::find($studentId);
    $course = Course::find($courseId);

    if ($student && $course) {
        $student->notify(new LowAttendanceNotification($percantage,$course->name));
    }
}

        return response()->json([
            'student_id' => $studentId,
            'course_id' => $courseId,
            'total_sessions' => $total,
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
            'attendance_percentage' => $percantage . '%',
        ]);
    }
    public function studentsReportForAllCourses($studentId)
    {
        $attendances = Attendance::where('student_id', $studentId)->get();

        $grouped = $attendances->groupBy('course_id');

        $report = [];

        foreach ($grouped as $course_id => $records) {
            $total = $records->count();
            $present = $records->where('status', 'present')->count();
            $absent = $records->where('status', 'absent')->count();
            $late = $records->where('status', 'late')->count();
            $percantage = $total > 0 ? round(($present / $total) * 100, 2) : 0;
        }

        $report[] = [
            'course_id' => $course_id,
            'total_sessions' => $total,
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
            'attendance_percentage' => $percantage . '%',
        ];
        return response()->json($report);
    }
}
