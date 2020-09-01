<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealCollection;
use App\Http\Requests\QueryRequest;

use App\Filters\CategoryFilter;
use App\Filters\TagFilter;
use App\Filters\WithFilter;
use App\Filters\DiffFilter;


class All extends Controller
{
    public function index(QueryRequest $request){

		app()->setLocale($request->query('lang'));
		$per_page = 5;
        $query = \App\Meal::query()->withTranslation();


		if ($request->has('category')) {     
			$categoryFilter = new CategoryFilter($request->query('category'), $query);
			$query = $categoryFilter->apply();
		}
		
		if ($request->has('tags')) {
			$tagsFilter = new TagFilter($request->query('tags'), $query);
			$query = $tagsFilter->apply();
		}
	
		if ($request->has('with')) {
			$withFilter = new WithFilter($request->query('with'), $query);
			$query = $withFilter->apply();
		} 
		
		if ($request->has('diff_time')) { 
			$diffTimeFilter = new DiffFilter($request->query('diff_time'), $query);
			$query = $diffTimeFilter->apply();   
		}
			
		if($request->has('per_page')){
			$per_page = $request->query('per_page');
		}

		return new MealCollection($query->paginate($per_page));
	}
}
