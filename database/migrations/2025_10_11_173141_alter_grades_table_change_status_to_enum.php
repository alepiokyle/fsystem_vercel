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
        // Update existing statuses to match new ENUM values
        \DB::statement("UPDATE grades SET status = 'draft' WHERE status = 'saved'");
        \DB::statement("UPDATE grades SET status = 'submitted' WHERE status = 'pending'");

        Schema::table('grades', function (Blueprint $table) {
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->string('status')->default('draft')->change();
        });
    }
};
