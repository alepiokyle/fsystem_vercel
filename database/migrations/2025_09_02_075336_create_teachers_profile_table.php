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
        Schema::create('teachers_profile', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->timestamps();
        });

        // Add foreign key to teachers_account after teachers_profile is created
        if (Schema::hasTable('teachers_account') && Schema::hasColumn('teachers_account', 'teachers_profile_id')) {
            Schema::table('teachers_account', function (Blueprint $table) {
                $table->foreign('teachers_profile_id')->references('id')->on('teachers_profile')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers_profile');
    }
};
