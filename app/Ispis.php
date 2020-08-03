<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ispis extends Model
{
     protected $fillable = [
        'meta',
        'data',
        'links'   
    ]; 

}
