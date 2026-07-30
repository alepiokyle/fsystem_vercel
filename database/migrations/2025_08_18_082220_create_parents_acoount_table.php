<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parents_account', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parents_profile_id')->nullable();

            $table->foreign('parents_profile_id')
                  ->references('id')
                  ->on('parents_profile')
                  ->onDelete('cascade');

            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');

            $table->unsignedBigInteger('user_role_id')->nullable();

            $table->boolean('is_active')
                  ->default(1)
                  ->comment('1=ACTIVATED, 0=DEACTIVATED');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parents_account');
    }
};
