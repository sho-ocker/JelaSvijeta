<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tag;
use App\Language;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Tag::class, function (Faker $faker) {
    
    static $i = 1;
    $locales = Language::pluck('lang');
    $data = array('slug' => Str::slug('tag '.$i,'-'));
    
    foreach ($locales as $locale){
        $data[$locale] = [
            'title' => 'Naslov taga '.$i.' na '.$locale.' jeziku'
        ];
    }
    $i++;

    return $data;
});
