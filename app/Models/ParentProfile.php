<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentProfile extends Model
{
    protected $table = 'parents_profile';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'contact_number',
        'date_of_birth',
        'gender',
        'relationship',
        'address',
    ];

    // Relationship to students
    public function students()
    {
        return $this->hasMany(UsersProfile::class, 'parents_profile_id', 'id');
    }
}
