<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'title'       => 'bail|required|string|max:255',
            'slug'        => 'bail|nullable|string|unique:products',
            'description' => 'bail|nullable|string',
            'price'       => 'bail|required|numeric',
            'image'       => 'bail|nullable|image',
            'quantity'    => 'bail|required|integer',
        ];

        if ($this->method() == 'PUT') {
            $rules['slug']  = 'bail|nullable|string|unique:products,id,:id';
        }

        return $rules;
    }
}
