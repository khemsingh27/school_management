<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    use HasFactory;
    protected $table = 'teacher_attendance';
    protected $fillable = [
        'student_id',
        'school_id',
        'class_id',
        'attendance_type',
        'created_at',
        'updated_at',
    ];
    public function attendance_type()
    {
        return $this->belongsTo(AttendanceType::class);
    }
}
