<?php

namespace Database\Seeders;

use App\Models\AdminAccount;
use App\Models\AdminProfile;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure admin role exists
        UserRole::updateOrCreate(
            ['id' => 4],
            ['role' => 'Admin']
        );

        // Create or get profile row
        $profile = AdminProfile::firstOrCreate([
            'first_name' => 'System',
            'last_name' => 'Admin',
        ]);

        // Create or update PACAdmin account
        AdminAccount::updateOrCreate(
            ['username' => 'PACAdmin'],
            [
                'name' => 'PAC Admin',
                'admins_profile_id' => $profile->id,
                'password' => Hash::make('123456'), // Your preferred password
                'user_role_id' => 4,
                'is_active' => 1,
            ]
        );
    }
}