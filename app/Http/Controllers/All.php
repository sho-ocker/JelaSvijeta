<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealCollection;
use App\Http\Requests\QueryRequest;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class CategoryFilter{

	protected $categoryId;
	protected $query;

	public function __construct($categoryIdParam, $queryParam)
	{
		$this->categoryId = $categoryIdParam;
    $this->query = $queryParam;
	}


	public function apply()
	{
		if ($this->categoryId == (string)(int)$this->categoryId) {
    		return $this->query->where('category_id',$this->categoryId);
    	}elseif ($this->categoryId == 'NULL') {
    		return $this->query->whereNull('category_id');
    	}elseif ($this->categoryId == '!NULL') {
        return $this->query->whereNotNull('category_id');
		}
	}
}


class TagFilter{

	protected $tagsRaw;
	protected $query;

	public function __construct($tagsRawParam, $queryParam)
	{
    $this->tagsRaw = $tagsRawParam;
    $this->query = $queryParam;
  }

	public function apply()
	{
    $tags = explode(',', $this->tagsRaw);

		foreach($tags as $tag){
        		$this->query = $this->query->whereHas('tags', function($q) use ($tag) {
            		$q->where('tags.id','=', $tag);
        		});
    }
    return $this->query;
	}
}


class WithFilter{

	protected $withRaw;
	protected $query;

	public function __construct($withRawParam, $queryParam)
	{
    $this->withRaw = $withRawParam;
    $this->query = $queryParam;
	}

	public function apply()
	{
    $with = explode(',', $this->withRaw);
    $arr = array(
				'ingredients',
				'category',
				'tags'
    );		
    $mutual = array_intersect($arr, $with);
		return $this->query->with($mutual);
	}
}


class DiffFilter{

	protected $timestamp;
	protected $query;

	public function __construct($timestampParam, $queryParam)
	{
		$this->timestamp = $timestampParam;
		$this->query = $queryParam;
	}

	public function apply()
	{
		$diffDate = new \DateTime();
		$diffDate->setTimestamp($this->timestamp);
		return $this->query->withTrashed()
				->where('created_at','>',$diffDate)
				->orWhere('updated_at','>',$diffDate)
				->orWhere('deleted_at','>',$diffDate);
	}
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class All extends Controller
{
    public function index(QueryRequest $request)
    {

		app()->setLocale($request->query('lang'));
		$per_page = 5;
        $query = \App\Meal::query()->withTranslation();


		if ($request->has('category')) {        
			$categoryFilter = new CategoryFilter($request->query('category'),$query);
			$query = $categoryFilter->apply();
		}
		
		if ($request->has('tags')) {
			$tagsFilter = new TagFilter($request->query('tags'),$query);
			$query = $tagsFilter->apply();
		}
	
		if ($request->has('with')) {
			$withFilter = new WithFilter($request->query('with'),$query);
			$query = $withFilter->apply();
		} 
		
		if ($request->has('diff_time')) { 
			$diffTimeFilter = new DiffFilter($request->query('diff_time'),$query);
			$query = $diffTimeFilter->apply();   
		}
			
			if($request->has('per_page')){
			$per_page = $request->query('per_page');
		}

		
		echo "<pre>";
		return  json_encode(new MealCollection($query->paginate($per_page)),JSON_PRETTY_PRINT);
		echo "</pre>";
	}
}
