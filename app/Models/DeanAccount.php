<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class DeanAccount extends Authenticatable
{
    use Notifiable;

    // Specify the table name
    protected $table = 'deans_account';

    // Assign the guard
    protected $guard = 'dean';

    // Fillable fields
    protected $fillable = [
        'deans_profile_id',
        'name',
        'username',
        'password',
        'user_role_id',
        'is_active',
        'created_by',
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
        return $this->belongsTo(DeanProfile::class, 'deans_profile_id', 'id');
    }

    // Creator relationship (admin who created this dean account)
    public function creator()
    {
        return $this->belongsTo(AdminAccount::class, 'created_by', 'id');
    }

    // Authentication identifier
    public function getAuthIdentifierName()
    {
        return 'id';
    }
}
