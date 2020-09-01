<?php

namespace App\Filters;

class CategoryFilter{

	protected $categoryId;
	protected $query;

	public function __construct($categoryIdParam, $queryParam){
		$this->categoryId = $categoryIdParam;
		$this->query = $queryParam;
	}
	

	public function apply(){

		if ($this->categoryId == (string)(int)$this->categoryId) {					// OVOOOOOOOOOO
			return $this->query->where('category_id',$this->categoryId);
			
    	}elseif ($this->categoryId == 'NULL') {
			return $this->query->whereNull('category_id');
			
    	}elseif ($this->categoryId == '!NULL') {
			return $this->query->whereNotNull('category_id');			
		}
		
	}
}