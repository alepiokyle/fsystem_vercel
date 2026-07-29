<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'department_id',
        'subject_name',
        'subject_code',
        'units',
        'year_level',
        'section',
        'semester',
        'school_year',
        'description',
        'status',
        'teacher_id',
    ];

    /**
     * Get the teacher assigned to this subject.
     */
    public function teacher()
    {
        return $this->belongsTo(TeacherAccount::class, 'teacher_id');
    }

    /**
     * Get the students enrolled in this subject.
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'student_subject', 'subject_id', 'student_id');
    }

    /**
     * Get the department of this subject.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the grades for this subject.
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
