<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Tag extends Model  implements TranslatableContract
{
    use Translatable;    
    protected $table = "tags";
    public $translatedAttributes = ['title'];
    protected $fillable = ['slug'];             
    protected $hidden = ['created_at','updated_at','deleted_at','translations','pivot'];


    public function meals()
    {
    	return $this->belongsToMany('App\Meal');
    }
}

class TagTranslation extends Model
{
	public $timestamps = false;
	protected $fillable = ['title']; 
}