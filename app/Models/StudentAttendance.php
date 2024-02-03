<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;
    protected $table = 'student_attendance';
    protected $fillable = [
        'student_id',
        'school_id',
        'class_id',
        'attendence_type',
        'created_at',
        'updated_at',
    ];
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
