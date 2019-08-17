<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users')->insert([
        	'name' => 'Admin User',
        	'email' => 'adminUser@gmail.com',
        	'password' => bcrypt('secret'),
        	'admin' => true,
        ]);

        DB::table('users')->insert([
        	'name' => 'Alpha Judge',
        	'email' => 'alphaJudge@gmail.com',
        	'password' => bcrypt('secret'),
        	'admin' => false,
        ]);

        DB::table('users')->insert([
        	'name' => 'Beta Judge',
        	'email' => 'betaJudge@gmail.com',
        	'password' => bcrypt('secret'),
        	'admin' => false,
        ]);

        DB::table('users')->insert([
        	'name' => 'Gamma Judge',
        	'email' => 'gammaJudge@gmail.com',
        	'password' => bcrypt('secret'),
        	'admin' => false,
        ]);

    }
}
