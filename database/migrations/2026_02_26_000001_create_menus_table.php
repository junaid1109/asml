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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('label'); // Display name (Home, About, Services, etc.)
            $table->string('route_name')->nullable(); // Route name (home, about, services.index, etc.)
            $table->string('url')->nullable(); // Custom URL if not using route
            $table->integer('order')->default(0); // Sort order
            $table->boolean('active')->default(true); // Show/hide in menu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
