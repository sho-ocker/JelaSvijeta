<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Language;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {   
    
    static $i = 1; 
    $locales = Language::pluck('lang');
    $data = array('slug' => Str::slug('category '.$i,'-'));
    
    foreach ($locales as $locale){
        $data[$locale] = [
            'title' => 'Naslov kategorije '.$i.' na '.$locale.' jeziku'
        ];              
    }    
    $i++;
    
    return $data;
});



