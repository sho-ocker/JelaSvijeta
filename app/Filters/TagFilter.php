<?php

namespace App\Filters;

class TagFilter{

    protected $tagsRaw;
    protected $query;

    public function __construct($tagsRawParam, $queryParam){
        $this->tagsRaw = $tagsRawParam;
        $this->query = $queryParam;
    }


    public function apply(){
        
        $tags = explode(',', $this->tagsRaw);

        foreach($tags as $tag){
            $this->query = $this->query->whereHas('tags', function($q) use ($tag) {
                $q->where('tags.id','=', $tag);
            });
        }
        
        return $this->query;
    }
}