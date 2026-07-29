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
        Schema::create('deans_profile', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->timestamps();
        });

        // Add foreign key to deans_account after deans_profile is created
        if (Schema::hasTable('deans_account') && Schema::hasColumn('deans_account', 'deans_profile_id')) {
            Schema::table('deans_account', function (Blueprint $table) {
                $table->foreign('deans_profile_id')->references('id')->on('deans_profile')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deans_profile');
    }
};
