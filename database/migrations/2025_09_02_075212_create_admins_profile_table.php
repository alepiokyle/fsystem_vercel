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
        Schema::create('admins_profile', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->timestamps();
        });

        // Add foreign key to admins_account after admins_profile is created
        if (Schema::hasTable('admins_account') && Schema::hasColumn('admins_account', 'admins_profile_id')) {
            Schema::table('admins_account', function (Blueprint $table) {
                $table->foreign('admins_profile_id')->references('id')->on('admins_profile')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins_profile');
    }
};
