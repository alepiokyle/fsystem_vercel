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
            // PostgreSQL specific syntax
            DB::statement('ALTER TABLE grades DROP CONSTRAINT IF EXISTS grades_status_check;');
            
            // Convert column to varchar first if needed
            DB::statement('ALTER TABLE grades ALTER COLUMN status TYPE VARCHAR(255);');
            
            // Add check constraint for enum values
            DB::statement("ALTER TABLE grades ADD CONSTRAINT grades_status_check CHECK (status IN ('draft', 'submitted', 'approved', 'rejected'));");
            
            // Set default value
            DB::statement("ALTER TABLE grades ALTER COLUMN status SET DEFAULT 'draft';");
        } else {
            // Standard MySQL behavior
            Schema::table('grades', function (Blueprint $table) {
                $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])
                      ->default('draft')
                      ->change();
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
        } else {
            Schema::table('grades', function (Blueprint $table) {
                $table->string('status')->change();
            });
        }
    }
};