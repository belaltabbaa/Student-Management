<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return StudentResource::collection($students);
    }

    public function store(StudentStoreRequest $request)
    {
        $student = Student::create($request->validated());
        return response()->json($student, 201);
    }

    public function show($id)
    {
        $student = Student::with('user')->findOrFail($id);
        return new StudentResource($student);
    }

    public function update(StudentUpdateRequest $request, $id)
    {
        $student = Student::findOrFail($id)->update($request->validated());
        return response()->json($student, 200);
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
    }

    public function registerStudentInCourse(Student $student, Course $course)
    {
        if ($student->courses()->where('course_id', $course->id)->exists()) {
            return response()->json(['exists already']);
        }
        $student->courses()->attach($course->id);
        return response()->json($student->load('courses'), 200);
    }

    public function destroyStudentFromCourse(Student $student, Course $course)
    {
        if (!$student->courses()->where('course_id', $course->id)->exists()) {
            return response()->json(['message' => 'not found']);
        }
        $student->courses()->detach($course->id);
    }
}
