<?php

namespace Database\Seeders;

use App\Models\category;
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
        // \App\Models\User::factory(10)->create();

        category::factory(3)->create();


        $this->call([
         //   CategoriesTableSeeder::class,
        //  UserTableSeeder::class,
        ]);
    }
}
