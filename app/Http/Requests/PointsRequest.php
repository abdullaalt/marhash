<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PointsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'address'=> ['required', 'string', 'max:100', 'min:3'],
			'who'=> ['required', 'string', 'max:100', 'min:3'],
			'action'=> ['required', 'string', 'max:20', 'min:3'],
			'coords'=> ['required', 'array']
		];
    }

    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()->all()], 403)); 
	}
}
