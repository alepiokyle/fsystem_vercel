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
        // Ensure core admin role exists
        UserRole::updateOrCreate(
            ['id' => 4],
            ['role' => 'Admin']
        );

        // Ensure Admin Profile exists
        $profile = AdminProfile::firstOrCreate(
            ['first_name' => 'System'],
            [
                'middle_name' => null,
                'last_name' => 'Admin',
            ]
        );

// Create/Force Update PACAdmin
        AdminAccount::updateOrCreate(
            ['username' => 'PACAdmin'],
            [
                'name' => 'PAC Admin',
                'admins_profile_id' => $profile->id,
                'password' => Hash::make('123456'),
                'user_role_id' => 4,
                'is_active' => 1,
            ]
        );

        // Create lowercase fallback 'pacadmin' as well
        AdminAccount::updateOrCreate(
            ['username' => 'pacadmin'],
            [
                'name' => 'PAC Admin',
                'admins_profile_id' => $profile->id,
                'password' => Hash::make('123456'),
                'user_role_id' => 4,
                'is_active' => 1,
            ]
        );
    }
}