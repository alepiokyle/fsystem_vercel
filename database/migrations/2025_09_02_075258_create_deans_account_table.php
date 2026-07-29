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
        Schema::create('deans_account', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deans_profile_id')->nullable();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->unsignedBigInteger('user_role_id')->nullable();
            $table->boolean('is_active')->default(1)->comment('1=ACTIVATED, 0=DEACTIVATED');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deans_account');
    }
};
