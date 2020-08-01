<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $table = "meals";

    public $translatedAttributes = [
        'title', 'description', 'status',
    ];

    protected $casts = [
        'category' => 'object',
        'tags' => 'object',
        'ingredients' => 'object'
    ];
}
 