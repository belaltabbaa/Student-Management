<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Models\Student;
use App\Models\Course;
use App\Notifications\LowAttendanceNotification;

Route::get('/test-email', function () {
    // اختار أي طالب مسجل
    $student = Student::first();

    // اختار أي دورة
    $course = Course::first();

    // نسبة حضور للاختبار
    $percentage = 65;

    // إرسال Notification
    $student->notify(new LowAttendanceNotification($percentage, $course->name));

    return "Notification sent successfully!";
});
