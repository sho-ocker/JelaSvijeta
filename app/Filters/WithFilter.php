<?php

namespace App\Filters;

class WithFilter{

    protected $withRaw;
    protected $query;

    public function __construct($withRawParam, $queryParam){
        $this->withRaw = $withRawParam;
        $this->query = $queryParam;
    }


    public function apply(){

        $with = explode(',', $this->withRaw);
        $arr = array('ingredients','category','tags');      		
        $mutual = array_intersect($arr, $with);

        return $this->query->with($mutual);
    }
}