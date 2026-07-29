<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class AdminAccount extends Authenticatable
{
    use Notifiable;

    // Specify the table name
    protected $table = 'admins_account';

    // Assign the guard
    protected $guard = 'admin';

    // Fillable fields
    protected $fillable = [
        'admins_profile_id',
        'name',
        'username',
        'password',
        'user_role_id',
        'is_active',
    ];

    // Hidden fields
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Role relationship
    public function role()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id', 'id');
    }

    // Profile relationship
    public function profile()
    {
        return $this->belongsTo(AdminProfile::class, 'admins_profile_id', 'id');
    }

    // Authentication identifier
    public function getAuthIdentifierName()
    {
        return 'id';
    }
}
