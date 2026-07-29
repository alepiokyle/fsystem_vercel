<?php

namespace App\Models;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TeacherAccount extends Authenticatable
{
    use Notifiable;

    // Specify the table name
    protected $table = 'teachers_account';

    // Assign the guard
    protected $guard = 'teacher';

    // Fillable fields
    protected $fillable = [
        'teachers_profile_id',
        'name',
        'username',
        'password',
        'user_role_id',
        'is_active',
        'last_login_at',
        'created_by',
    ];

    // Hidden fields
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast fields
    protected $casts = [
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Role relationship
    public function role()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id', 'id');
    }

    // Profile relationship
    public function profile()
    {
        return $this->belongsTo(TeacherProfile::class, 'teachers_profile_id', 'id');
    }

    // Creator relationship (admin who created this teacher account)
    public function creator()
    {
        return $this->belongsTo(AdminAccount::class, 'created_by', 'id');
    }

    // Grades relationship
    public function grades()
    {
        return $this->hasMany(Grade::class, 'teacher_id');
    }

    // Authentication identifier
    public function getAuthIdentifierName()
    {
        return 'id';
    }
}
