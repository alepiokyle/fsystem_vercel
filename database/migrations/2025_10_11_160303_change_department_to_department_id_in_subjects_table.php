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
        Schema::table('subjects', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable()->after('department');
        });

        // Update department_id based on department name
        \DB::statement("UPDATE subjects SET department_id = (SELECT id FROM departments WHERE name = subjects.department LIMIT 1)");

        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('department');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->string('department')->nullable()->after('id');
        });

        // Update department name based on department_id
        \DB::statement("UPDATE subjects SET department = (SELECT name FROM departments WHERE id = subjects.department_id LIMIT 1)");

        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
    }
};
