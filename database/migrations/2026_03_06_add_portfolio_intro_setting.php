<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add portfolio_intro setting if it doesn't exist
        $exists = DB::table('settings')->where('key', 'portfolio_intro')->exists();
        
        if (!$exists) {
            DB::table('settings')->insert([
                'key' => 'portfolio_intro',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Delete the portfolio_intro setting
        DB::table('settings')->where('key', 'portfolio_intro')->delete();
    }
};
