<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create(['name' => 'Computer Science']);
        Department::create(['name' => 'Business Administration']);
        Department::create(['name' => 'Engineering']);
        Department::create(['name' => 'Mathematics']);
        Department::create(['name' => 'Physics']);
        Department::create(['name' => 'Chemistry']);
        Department::create(['name' => 'Biology']);
        Department::create(['name' => 'English']);
        Department::create(['name' => 'History']);
    }
}
