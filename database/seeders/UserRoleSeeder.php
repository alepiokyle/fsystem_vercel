<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id' => 4, 'role' => 'Admin'],
            ['id' => 5, 'role' => 'Dean'],
            ['id' => 6, 'role' => 'Teacher'],
            ['id' => 7, 'role' => 'Student'],
            ['id' => 8, 'role' => 'Parent'],
        ];

        foreach ($roles as $roleData) {
            UserRole::updateOrCreate(
                ['id' => $roleData['id']],
                ['role' => $roleData['role']]
            );
        }
    }
}
