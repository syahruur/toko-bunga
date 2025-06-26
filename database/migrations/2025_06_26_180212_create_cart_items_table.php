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
        // Cart items table is already created in the carts migration
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cart items table is already handled in the carts migration
    }
};
