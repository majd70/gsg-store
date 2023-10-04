<?php

namespace Database\Seeders;

use App\Models\category;
use App\Models\caterory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //QRM:Eloquent Model
           category::create([
            'name'=>'Category Model',
            'slug'=>'category-model',
            'status'=>'active'


           ]);

           category::create([
            'name'=>'Category Model2',
            'slug'=>'category-model2',
            'status'=>'active'


           ]);

          return;

        //Query Builder
        DB::connection('mysql')->table('categories')->insert([
           'name'=>'My First Caterory',
           'slug'=>'my-first-category',
           'status'=>'active'


        ]);

        DB::connection('mysql')->table('categories')->insert([
            'name'=>'My Sub Caterory',
            'slug'=>'my-sub-category',
            'parent_id'=>1,
            'status'=>'active'


         ]);


        //SQL command
        DB::statement("INSERT INTO catagories(name slug status )
        values ('My Sub Caterory','my-sub-category','active')");
    }
}
