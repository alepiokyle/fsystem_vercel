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
        Schema::table('grades', function (Blueprint $table) {
            $table->decimal('quiz', 5, 2)->nullable();
            $table->decimal('total_quiz', 5, 2)->nullable();
            $table->decimal('assignment', 5, 2)->nullable();
            $table->decimal('total_assignment', 5, 2)->nullable();
            $table->decimal('attendance_score', 5, 2)->nullable();
            $table->decimal('total_attendance_score', 5, 2)->nullable();
            $table->decimal('exam', 5, 2)->nullable();
            $table->decimal('total_exam', 5, 2)->nullable();
            $table->decimal('performance', 5, 2)->nullable();
            $table->decimal('total_performance', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn([
                'quiz', 'total_quiz',
                'assignment', 'total_assignment',
                'attendance_score', 'total_attendance_score',
                'exam', 'total_exam',
                'performance', 'total_performance'
            ]);
        });
    }
};
