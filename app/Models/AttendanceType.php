<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceType extends Model
{
    use HasFactory;
    protected $table = 'attendance_type';
    protected $fillable = [
        'type',
    ];
    public function studentAttendance()
    {
        return $this->hasOne(StudentAttendance::class);
    }
    public function teacherAttendance()
    {
        return $this->hasOne(TeacherAttendance::class);
    }
}
