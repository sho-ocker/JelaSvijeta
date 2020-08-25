<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Meal;
use App\Language;
use App\Category;
use Faker\Generator as Faker;

$factory->define(Meal::class, function (Faker $faker) {
   
    static $i = 1;
	$locales = Language::pluck('lang');
	$categories = Category::all();
	$category = $categories->random(rand(0, 1))->first();
	    
    $data = array('category_id' => $category ? $category->id : $category);


	foreach ($locales as $locale) {
	 	$data[$locale] = [
	 		'title' => 'Naslov jela '.$i.' na '.$locale.' jeziku',
	 		'description' => 'Opis jela '.$i++.' na ' .$locale.' jeziku'
	 	];
    }

    return $data;
});
