<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            AddInitialEntriesToEntriesTable::class,
            AddActiveEntry::class,
            AddActiveCategory::class,
            CategoriesTableSeeder::class,
            SchoolSeeder::class,
        ]);
    }
}
