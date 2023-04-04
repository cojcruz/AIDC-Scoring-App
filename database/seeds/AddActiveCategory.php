<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddActiveCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('active_category')->insert([
            'code' => NULL,
        ]);
    }
}
