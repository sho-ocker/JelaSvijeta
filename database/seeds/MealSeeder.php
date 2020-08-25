<?php

use App\Ingredient;
use App\Tag;
use App\Meal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){                           //SEEDANJE FAKE PODACIMA


        $ingredients = factory(Ingredient::class, 10)->create();

    	$tags = factory(Tag::class, 5)->create();

        factory(Meal::class, 10)->create()->each(function ($meal) use ($ingredients,$tags) { 
    		$meal->ingredients()->saveMany(
    			$ingredients->random(rand(1, 3))
    		);
    		$meal->tags()->saveMany(
    			$tags->random(rand(1, 3))
    		);
        });      
    }
}
