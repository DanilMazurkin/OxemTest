<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryFormRequest extends FormRequest
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
            'id_parent_category' => ['required', 'integer'],
            'name' => ['required', 'string','max:255'],
        ];
    }

    public function messages() 
    {
        return [
            'external_id.required' => ':attribute is required',
            'id_parent_category.required' => ':attribute is required',
            'name.required' => ':attribute is required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
      throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
