<?php

use Illuminate\Database\Seeder;

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
