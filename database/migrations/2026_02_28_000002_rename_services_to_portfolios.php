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
        // First rename existing portfolios table to advisory
        if (Schema::hasTable('portfolios')) {
            Schema::rename('portfolios', 'advisory');
        }
        
        // Then rename services table to portfolios
        if (Schema::hasTable('services')) {
            Schema::rename('services', 'portfolios');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the order
        if (Schema::hasTable('portfolios')) {
            Schema::rename('portfolios', 'services');
        }
        
        if (Schema::hasTable('advisory')) {
            Schema::rename('advisory', 'portfolios');
        }
    }
};
