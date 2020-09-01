<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;


class Category extends Model implements TranslatableContract
{
    use Translatable;    
    protected $table = "categories";
    public $translatedAttributes = ['title'];
    protected $fillable = ['slug'];
    protected $hidden = ['created_at','updated_at','deleted_at','translations'];


    public function meals(){
    	return $this->hasMany('App\Meal');
    }
}


class CategoryTranslation extends Model{    

    public $timestamps = false;
    protected $fillable = ['title'];
}
