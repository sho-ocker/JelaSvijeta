<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class QueryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){

        return [
            'lang' => 'required|size:2|alpha',
            'per_page' => 'sometimes|integer',
            'page' => 'sometimes|integer',              //nullable
            'category' => 'sometimes|between:1,5',
            'tags' => 'sometimes|filled',
            'with' => 'sometimes|string|filled',
            'diff_time' => 'sometimes|integer'
        ];
    }


   protected function failedValidation(Validator $validator){ 
        throw new HttpResponseException(response()->json($validator->errors()->all(), 422));
   }
}

