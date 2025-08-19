<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('students', StudentController::class);

Route::apiResource('users', UserController::class);

Route::get('courses', [CourseController::class, 'index']);


Route::middleware('auth:sanctum')->group(
    function () {
        Route::post('/students/{student}/courses/{course}/register', [StudentController::class, 'registerStudentInCourse'])->middleware('IsAdmin');
        
        Route::get('/student/{student}/courses', [StudentController::class, 'getallcourse'])->middleware('IsAdmin');

        Route::delete('students/{student}/courses/{course}', [StudentController::class, 'destroyStudentFromCourse'])->middleware('IsAdmin');

        Route::get('course/{course}/students', [CourseController::class, 'getallstudent'])->middleware('IsAdmin');
    }
);

Route::post('register', [UserController::class, 'register']);

Route::post('login', [UserController::class, 'login']);

Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
