<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;


class MealCollection extends ResourceCollection{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request){

        if($request->query('page')){
            $pr = $request->query('page');
            $prev = $request->fullUrl();
            $prev = Str::replaceFirst('page='.$pr,'page='.($pr-1), $prev);

            if ($request->query('page') == 1)
                $prev = null;

            $next = $request->fullUrl();
            $next = Str::replaceFirst('page='.$pr,'page='.($pr+1), $next);

            if($request->query('page') == ceil(($this->total()/$request->query('per_page'))))
                $next = null;
            $self = $request->fullUrl();

        }else{
            $prev = null;
            if(ceil(($this->total()/$request->query('per_page'))) == 1)
                $next = null;
            
            else
                $next = $request->fullUrl().'&page=2';

            $self = $request->fullUrl().'&page=1';
        }
        

        if(!$request->query('page')){
            $currentPage = 1;

        }else{
            $currentPage = $request->query('page');
        }
    

        
        return [
            'meta' => [
                'currentPage' => (int)$currentPage,
                'totalItems' => $this->total(),
                'itemsPerPage' => (int)$request->query('per_page'),
                'totalPages' => ceil(($this->total()/$request->query('per_page'))),
            ],
            'data' => $this->collection,
            'links' => [
               'prev' => $prev,
               'next' => $next,
               'self' => $self
            ]
        ];
    }
}