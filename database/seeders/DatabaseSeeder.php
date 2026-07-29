<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed minimal required roles and default admin (skip User factory to avoid users table column mismatch)



        // Ensure core roles exist
        $this->call([UserRoleSeeder::class]);


        // Ensure default admin exists
        $this->call([AdminAccountSeeder::class]);

        // (Optional) other seeders...
        // $this->call([DepartmentSeeder::class]);
    }
}

