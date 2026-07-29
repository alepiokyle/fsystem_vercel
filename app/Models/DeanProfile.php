<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeanProfile extends Model
{
    protected $table = 'deans_profile';

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
