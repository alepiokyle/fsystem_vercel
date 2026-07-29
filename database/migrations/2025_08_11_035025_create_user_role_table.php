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
        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->timestamps();
        });

        // Add foreign key to users table after user_role is created
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'user_role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('user_role_id')->references('id')->on('user_role')->onDelete('set null');
            });
        }

        // Add foreign key to parents_account table
        if (Schema::hasTable('parents_account') && Schema::hasColumn('parents_account', 'user_role_id')) {
            Schema::table('parents_account', function (Blueprint $table) {
                $table->foreign('user_role_id')->references('id')->on('user_role')->onDelete('set null');
            });
        }

        // Add foreign key to admins_account table
        if (Schema::hasTable('admins_account') && Schema::hasColumn('admins_account', 'user_role_id')) {
            Schema::table('admins_account', function (Blueprint $table) {
                $table->foreign('user_role_id')->references('id')->on('user_role')->onDelete('set null');
            });
        }

        // Add foreign key to deans_account table
        if (Schema::hasTable('deans_account') && Schema::hasColumn('deans_account', 'user_role_id')) {
            Schema::table('deans_account', function (Blueprint $table) {
                $table->foreign('user_role_id')->references('id')->on('user_role')->onDelete('set null');
            });
        }

        // Add foreign key to teachers_account table
        if (Schema::hasTable('teachers_account') && Schema::hasColumn('teachers_account', 'user_role_id')) {
            Schema::table('teachers_account', function (Blueprint $table) {
                $table->foreign('user_role_id')->references('id')->on('user_role')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys first if they exist
        $tables = ['teachers_account', 'deans_account', 'admins_account', 'parents_account', 'users'];
        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'user_role_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropForeign(['user_role_id']);
                });
            }
        }

        Schema::dropIfExists('user_role');
    }
};
