<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherProfile extends Model
{
    protected $table = 'teachers_profile';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
