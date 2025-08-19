<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses, 200);
    }

    public function getallstudent(Course $course){
        $students = $course->students;
        return response()->json($students,200);
    }
}
