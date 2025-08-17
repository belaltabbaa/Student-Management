<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'code',
        'first_name',
        'last_name',
        'gender',
        'phone',
        'status',
        'email',
        'address',
    ];
    protected $table = 'students';

    protected static function booted()
    {
        static::creating(function ($student) {
            if (!$student->code) {
                $student->code = 'STU-' . str_pad((Student::max('id') + 1), 5, '0', STR_PAD_LEFT);
            }
        });
    }
}
