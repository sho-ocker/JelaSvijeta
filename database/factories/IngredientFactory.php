<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ingredient;
use App\Language;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Ingredient::class, function (Faker $faker) {

    static $i = 1;
    $locales = Language::pluck('lang');
    $data = array('slug' => Str::slug('ingredient '.$i,'-'));
    
    foreach ($locales as $locale) {
        $data[$locale] = [
            'title' => 'Naslov sastojka '.$i.' na '.$locale.' jeziku'
        ];
    }
    $i++;
    
    return $data;
});
