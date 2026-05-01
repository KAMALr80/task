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
        // Use raw SQL for better compatibility with ENUM changes
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE tasks MODIFY COLUMN status VARCHAR(255) DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE tasks MODIFY COLUMN status ENUM('pending', 'in-progress', 'completed', 'overdue') DEFAULT 'pending'");
    }
};
