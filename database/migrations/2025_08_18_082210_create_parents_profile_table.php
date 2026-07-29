<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parents_profile', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('contact_number');
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('relationship'); // e.g., Mother, Father, Guardian
            $table->string('address');
            $table->timestamps();
        });

        // Add foreign key to users_profile after parents_profile is created
        if (Schema::hasTable('users_profile') && Schema::hasColumn('users_profile', 'parents_profile_id')) {
            Schema::table('users_profile', function (Blueprint $table) {
                $table->foreign('parents_profile_id')->references('id')->on('parents_profile')->onDelete('set null');
            });
        }

        // Add foreign key to parents_account after parents_profile is created
        if (Schema::hasTable('parents_account') && Schema::hasColumn('parents_account', 'parents_profile_id')) {
            Schema::table('parents_account', function (Blueprint $table) {
                $table->foreign('parents_profile_id')->references('id')->on('parents_profile')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys first if they exist
        $tables = ['users_profile', 'parents_account'];
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'parents_profile_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropForeign(['parents_profile_id']);
                });
            }
        }

        Schema::dropIfExists('parents_profile');
    }
};
