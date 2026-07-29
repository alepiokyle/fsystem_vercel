<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'teacher_id',
        'prelim',
        'midterm',
        'semi_final',
        'final',
        'term_grade',
        'remarks',
        'status',
        'semester',
        'school_year',
        'quiz',
        'total_quiz',
        'assignment',
        'total_assignment',
        'attendance_score',
        'total_attendance_score',
        'exam',
        'total_exam',
        'performance',
        'total_performance',
        'is_done',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(TeacherAccount::class, 'teacher_id');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}
