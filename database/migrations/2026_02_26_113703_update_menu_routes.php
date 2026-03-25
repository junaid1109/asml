<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update menu routes from old names to new ones
        DB::table('menus')->where('route_name', 'services.index')->update(['route_name' => 'portfolio.index']);
        DB::table('menus')->where('route_name', 'admin.services.index')->update(['route_name' => 'admin.portfolios.index']);
        DB::table('menus')->where('route_name', 'admin.portfolio.index')->update(['route_name' => 'admin.advisory.index']);
        DB::table('menus')->where('route_name', 'admin.portfolio.create')->update(['route_name' => 'admin.advisory.create']);
        DB::table('menus')->where('route_name', 'admin.portfolio.edit')->update(['route_name' => 'admin.advisory.edit']);
        DB::table('menus')->where('route_name', 'admin.portfolio.store')->update(['route_name' => 'admin.advisory.store']);
        DB::table('menus')->where('route_name', 'admin.portfolio.update')->update(['route_name' => 'admin.advisory.update']);
        DB::table('menus')->where('route_name', 'admin.portfolio.destroy')->update(['route_name' => 'admin.advisory.destroy']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert menu routes back to old names
        DB::table('menus')->where('route_name', 'portfolio.index')->update(['route_name' => 'services.index']);
        DB::table('menus')->where('route_name', 'admin.portfolios.index')->update(['route_name' => 'admin.services.index']);
        DB::table('menus')->where('route_name', 'admin.advisory.index')->update(['route_name' => 'admin.portfolio.index']);
        DB::table('menus')->where('route_name', 'admin.advisory.create')->update(['route_name' => 'admin.portfolio.create']);
        DB::table('menus')->where('route_name', 'admin.advisory.edit')->update(['route_name' => 'admin.portfolio.edit']);
        DB::table('menus')->where('route_name', 'admin.advisory.store')->update(['route_name' => 'admin.portfolio.store']);
        DB::table('menus')->where('route_name', 'admin.advisory.update')->update(['route_name' => 'admin.portfolio.update']);
        DB::table('menus')->where('route_name', 'admin.advisory.destroy')->update(['route_name' => 'admin.portfolio.destroy']);
    }
};
