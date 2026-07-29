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
            if (!Schema::hasColumn('grades', 'quiz')) {
                $table->decimal('quiz', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('grades', 'total_quiz')) {
                $table->decimal('total_quiz', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('grades', 'assignment')) {
                $table->decimal('assignment', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('grades', 'total_assignment')) {
                $table->decimal('total_assignment', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('grades', 'attendance_score')) {
                $table->decimal('attendance_score', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('grades', 'total_attendance_score')) {
                $table->decimal('total_attendance_score', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('grades', 'exam')) {
                $table->decimal('exam', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('grades', 'total_exam')) {
                $table->decimal('total_exam', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('grades', 'performance')) {
                $table->decimal('performance', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('grades', 'total_performance')) {
                $table->decimal('total_performance', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('grades', 'term')) {
                $table->enum('term', ['prelim', 'midterm', 'semi', 'finals', 'semi-final', 'final', 'term-grade'])->nullable();
            }
            if (!Schema::hasColumn('grades', 'is_done')) {
                $table->boolean('is_done')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            //
        });
    }
};
