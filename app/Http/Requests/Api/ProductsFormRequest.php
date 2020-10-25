<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductsFormRequest extends FormRequest
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
               'external_id' => ['required', 'integer'],
               'name' => ['required', 'string','max:255'],
               'describe' => ['required', 'string','max:1000'],
               'price' => ['required', 'numeric'],
               'quantity' => ['required', 'integer'],
        ];
    }

    public function messages() 
    {
        return [
            'external_id.required' => ':attribute is required',
            'price.required' => ':attribute is required',
            'name.required' => ':attribute is required',
            'describe.required' => ':attribute is required',
            'quantity.required' => ':attribute is required',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
      throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
