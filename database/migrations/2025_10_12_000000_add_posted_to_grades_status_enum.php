<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            // PostgreSQL specific update to add 'posted' option
            DB::statement('ALTER TABLE grades DROP CONSTRAINT IF EXISTS grades_status_check;');
            DB::statement('ALTER TABLE grades ALTER COLUMN status TYPE VARCHAR(255);');
            DB::statement("ALTER TABLE grades ADD CONSTRAINT grades_status_check CHECK (status IN ('draft', 'submitted', 'approved', 'rejected', 'posted'));");
            DB::statement("ALTER TABLE grades ALTER COLUMN status SET DEFAULT 'draft';");
        } else {
            // MySQL standard behavior
            Schema::table('grades', function (Blueprint $table) {
                $table->enum('status', ['draft', 'submitted', 'approved', 'rejected', 'posted'])->default('draft')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE grades DROP CONSTRAINT IF EXISTS grades_status_check;');
            DB::statement("ALTER TABLE grades ADD CONSTRAINT grades_status_check CHECK (status IN ('draft', 'submitted', 'approved', 'rejected'));");
        } else {
            Schema::table('grades', function (Blueprint $table) {
                $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft')->change();
            });
        }
    }
};