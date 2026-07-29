<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ParentAccount extends Authenticatable
{
    use Notifiable;

    // Specify the table name
    protected $table = 'parents_account';

    // Assign the guard
    protected $guard = 'parent';

    // Fillable fields
    protected $fillable = [
        'parents_profile_id',
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
        return $this->belongsTo(ParentProfile::class, 'parents_profile_id', 'id');
    }

    // Authentication identifier
    public function getAuthIdentifierName()
    {
        return 'id';
    }
}
