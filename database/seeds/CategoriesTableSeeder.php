<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('categories')->insert([
        	'code' => 'J1A-CLS',
        	'name' => 'Junior 1 Solo Classical - A'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J1B-CLS',
        	'name' => 'Junior 1 Solo Classical - B'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J1C-CLS',
        	'name' => 'Junior 1 Solo Classical - C'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J2A-CLS',
        	'name' => 'Junior 2 Solo Classical - A'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J2B-CLS',
        	'name' => 'Junior 2 Solo Classical - B'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J2C-CLS',
        	'name' => 'Junior 2 Solo Classical - C'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J3A-CLS',
        	'name' => 'Junior 3 Solo Classical - A'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J3B-CLS',
        	'name' => 'Junior 3 Solo Classical - B'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J4A-CLS',
        	'name' => 'Junior 4 Solo Classical - A'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J4B-CLS',
        	'name' => 'Junior 4 Solo Classical - B'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J4C-CLS',
        	'name' => 'Junior 4 Solo Classical - C'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J5A-CLS',
        	'name' => 'Junior 5 Solo Classical - A'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J5C-CLS',
        	'name' => 'Junior 5 Solo Classical - C'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J2B-BCS',
        	'name' => 'Junior 2 Solo Contemporary - B'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J2C-BCS',
        	'name' => 'Junior 2 Solo Contemporary - C'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J4A-BCS ',
        	'name' => 'Junior 4 Solo Contemporary - A'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J4C-BCS',
        	'name' => 'Junior 4 Solo Contemporary - C'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J5A-BCS',
        	'name' => 'Junior 5 Solo Contemporary - A'
        ]);

        DB::table('categories')->insert([
        	'code' => 'SRA-CLS',
        	'name' => 'Senior Solo Classical - A'
        ]);

        DB::table('categories')->insert([
        	'code' => 'SRC-CLS',
        	'name' => 'Senior Solo Classical - C'
        ]);

        DB::table('categories')->insert([
        	'code' => 'SRA-BCS',
        	'name' => 'Senior Solo Contemporary - A'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J3A-BCS',
        	'name' => 'Junior 3 Contemporary - A'
        ]);

        DB::table('categories')->insert([
        	'code' => 'J3B-BCS',
        	'name' => 'Junior 3 Contemporary - B'
        ]);

        DB::table('categories')->insert([
        	'code' => 'SRD',
        	'name' => 'Senior Contemporary Duo'
        ]);

        DB::table('categories')->insert([
        	'code' => 'JRD',
        	'name' => 'Junior Contemporary Duo'
        ]);

        DB::table('categories')->insert([
        	'code' => 'OGA-G',
        	'name' => 'Open Group Classical A - Girls'
        ]);

        DB::table('categories')->insert([
        	'code' => 'OGB-G',
        	'name' => 'Open Group Classical B - Girls'
        ]);

        DB::table('categories')->insert([
        	'code' => 'OGC-G ',
        	'name' => 'Open Group Classical C - Girls'
        ]);

        DB::table('categories')->insert([
        	'code' => 'OGA-M',
        	'name' => 'Open Group Classical A - Mixed'
        ]);

        DB::table('categories')->insert([
        	'code' => 'OGB-M',
        	'name' => 'Open Group Classical B - Mixed'
        ]);

        DB::table('categories')->insert([
        	'code' => 'OGC-M',
        	'name' => 'Open Group Classical C - Mixed'
        ]);

        DB::table('categories')->insert([
        	'code' => 'OGD-G',
        	'name' => 'Open Group Contemporary Girls - D'
        ]);

        DB::table('categories')->insert([
        	'code' => 'OGE-G',
        	'name' => 'Open Group Contemporary Girls - E'
        ]);
             
        DB::table('categories')->insert([
        	'code' => 'OGF-G',
        	'name' => 'Open Group Contemporary Girls - F'
        ]);

        DB::table('categories')->insert([
        	'code' => 'OGF-M',
        	'name' => 'Open Group Contemporary Mixed - F'
        ]);
    }
}
