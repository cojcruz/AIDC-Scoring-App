<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddActiveEntry extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('active_entry')->insert([
        	'code' => NULL,
        ]);
    }
}
