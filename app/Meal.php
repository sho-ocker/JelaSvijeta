<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;


class Meal extends Model implements TranslatableContract{

    use SoftDeletes;
    use Translatable;
    
    protected $table = "meals";
    public $translatedAttributes = ['title','description'];
    protected $hidden = ['category_id','translations','created_at','updated_at','deleted_at'];
    protected $fillable = ['updated_at','deleted_at','created_at'];

    protected $dates = ['deleted_at'];
    protected $appends = ['status'];


    public function category(){
    	return $this->belongsTo('App\Category');
    }


    public function tags(){
        return $this->belongsToMany('App\Tag');
    }


    public function ingredients(){
        return $this->belongsToMany('App\Ingredient'); 
    }  


    public function getStatusAttribute(){

        $status = 'created'; 
    
        if (request('diff_time')) {
            
            $diffDate = new \DateTime();
            $diffDate->setTimestamp(request('diff_time'));

            if ($this->updated_at > $diffDate && $this->updated_at > $this->created_at) {
                $status = 'modified';
            }

            if ($this->deleted_at > $diffDate) {
                $status = 'deleted';
            }    
        }

        return $status;
    }
}


 
class MealTranslation extends Model{

	public $timestamps = false;
	protected $fillable = ['title', 'description'];
}