<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

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
               'category_id' => ['required', 'json']
        ];
    }
}
