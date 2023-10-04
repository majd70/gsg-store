<?php

namespace Database\Factories;

use App\Models\category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class categoryFactory extends Factory
{
  //  protected $model=category::class;//لربط الفاكتوري مع المودل الخاص فيه و بتكون معمولة بشكل تلقائي

    /**
     * Define the model's default state.
     *
     *
     * @return array
     */
    public function definition()
    {
        //Faker(return random data)

          //select id FROM categories ORDER BY RAND() LIMIT 1
          //get methoud return collection
          //collection=array of result (row)(row=object)
          //collection contian some helper method
          //limit function spesified the number of recourd that return from database
          //first method will select the first recourd that retern from database
          //الصف الي برجع عيارة عن اوبجيكت وكل عمود في الصف بكون بروباريتي لهذا الاوبجيكت

         $category= DB::table('categories')->inRandomOrder()->limit(1)->first('id');
        $name=$this->faker->word(2,true);//true for return result as string
        $status=['active','draft'];
        return [
            'name'=> $name,
           'slug'=>Str::slug($name),
           'parent_id'=>$category?$category->id:null ,
           'description'=>$this->faker->word(200,true),
           'image_path'=>$this->faker->imageUrl(),//return random imge url
            'status'=>$status[rand(0,1)],
        ];
    }
}
