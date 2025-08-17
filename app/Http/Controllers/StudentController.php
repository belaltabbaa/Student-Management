<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students, 200);
    }

    public function store(StudentStoreRequest $request)
    {
        $student = Student::create($request->validated());
        return response()->json($student, 201);
    }
    
    public function show($id) {
        $student = Student::findOrFail($id);
        return response()->json($student, 200);
    }

    public function update(StudentUpdateRequest $request, $id) {
        $student = Student::findOrFail($id)->update($request->validated());
        return response()->json($student, 200);
    }

    public function destroy($id) {
        Student::findOrFail($id)->delete();
    }
}
