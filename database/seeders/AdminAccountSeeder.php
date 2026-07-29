<?php

namespace Database\Seeders;

use App\Models\AdminAccount;
use App\Models\AdminProfile;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure admin role exists (required by middleware)
        UserRole::updateOrCreate(
            ['id' => 4],
            ['role' => 'Admin']
        );

        // Create a profile row (admins_account.admins_profile_id is foreign key)
        $profile = AdminProfile::create([
            'first_name' => 'System',
            'middle_name' => null,
            'last_name' => 'Admin',
        ]);

        AdminAccount::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'System Admin',
                'admins_profile_id' => $profile->id,
                'password' => Hash::make('Admin12345'),
                'user_role_id' => 4,
                'is_active' => 1,
            ]
        );
    }
}

