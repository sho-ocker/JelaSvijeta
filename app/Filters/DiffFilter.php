<?php

namespace App\Filters;

class DiffFilter{

    protected $timestamp;
    protected $query;

    public function __construct($timestampParam, $queryParam){
        $this->timestamp = $timestampParam;
        $this->query = $queryParam;
    }
    

    public function apply(){

        $diffDate = new \DateTime();
        $diffDate->setTimestamp($this->timestamp);
            
        return $this->query->withTrashed()
                ->where('created_at','>',$diffDate)
                ->orWhere('updated_at','>',$diffDate)
                ->orWhere('deleted_at','>',$diffDate);
    }
}