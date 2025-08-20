<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
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
}
