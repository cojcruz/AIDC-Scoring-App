<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AddInitialEntriesToEntriesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entries')->insert([
        	'code' => '552',
            'category' => 'J5A-CLS',
            'judge_a' => '92.4',
            'judge_b' => '88.7',
            'judge_c' => '89.9',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '550',
            'category' => 'J5A-CLS',
            'judge_a' => '91.2',
            'judge_b' => '88.5',
            'judge_c' => '86.75',
            'created_at' => Carbon::now(),
        ]);      

        DB::table('entries')->insert([
            'code' => '545',
            'category' => 'J5A-CLS',
            'judge_a' => '89.8',
            'judge_b' => '84.5',
            'judge_c' => '93.75',
            'created_at' => Carbon::now(),
        ]);      

        DB::table('entries')->insert([
            'code' => '544',
            'category' => 'J5A-CLS',
            'judge_a' => '81.1',
            'judge_b' => '83',
            'judge_c' => '82.7',
            'created_at' => Carbon::now(),
        ]);      

        DB::table('entries')->insert([
            'code' => '543',
            'category' => 'J5A-CLS',
            'judge_a' => '72.44',
            'judge_b' => '79.65',
            'judge_c' => '77.5',
            'created_at' => Carbon::now(),
        ]);      

        DB::table('entries')->insert([
            'code' => '541',
            'category' => 'J5A-CLS',
            'judge_a' => '85.2',
            'judge_b' => '87.1',
            'judge_c' => '83.1',
            'created_at' => Carbon::now(),
        ]);      

        DB::table('entries')->insert([
            'code' => '540',
            'category' => 'J5A-CLS',
            'judge_a' => '91.38',
            'judge_b' => '94.45',
            'judge_c' => '89.5',
            'created_at' => Carbon::now(),
        ]);  

        DB::table('entries')->insert([
            'code' => '537',
            'category' => 'J5A-CLS',
            'created_at' => Carbon::now(),
        ]);  

        DB::table('entries')->insert([
            'code' => '534',
            'category' => 'J5A-CLS',
            'created_at' => Carbon::now(),
        ]);  

        DB::table('entries')->insert([
            'code' => '532',
            'category' => 'J5A-CLS',
            'created_at' => Carbon::now(),
        ]);  

        DB::table('entries')->insert([
            'code' => '530',
            'category' => 'J5A-CLS',
            'created_at' => Carbon::now(),
        ]);  

        DB::table('entries')->insert([
            'code' => '529',
            'category' => 'J5A-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '527',
            'category' => 'J5A-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '524',
            'category' => 'J5A-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '520',
            'category' => 'J5A-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '618',
            'category' => 'SRA-CLS',
            'judge_a' => '79.1',
            'judge_b' => '83.7',
            'judge_c' => '81.2',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '615',
            'category' => 'SRA-CLS',
            'judge_a' => '86.1',
            'judge_b' => '84.6',
            'judge_c' => '88',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '609',
            'category' => 'SRA-CLS',
            'judge_a' => '90.1',
            'judge_b' => '89.8',
            'judge_c' => '91.7',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '604',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '600',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '598',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '596',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '595',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '593',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '591',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '588',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '585',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '584',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '582',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '581',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '579',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '576',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '573',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);

        DB::table('entries')->insert([
            'code' => '571',
            'category' => 'SRA-CLS',
            'created_at' => Carbon::now(),
        ]);
    }
}
