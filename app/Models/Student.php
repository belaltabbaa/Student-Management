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
        'gender',
        'phone',
        'status',
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
    public function courses(){
        return $this->belongsToMany(Course::class,'course_student')->withPivot('status')->withTimestamps();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
