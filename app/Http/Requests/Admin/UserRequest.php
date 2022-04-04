<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|string|email|max:255|unique:users',
            'is_admin' => 'bail|required|boolean',
            'password' => ['bail', 'required', 'confirmed', Password::defaults()],
        ];

        if ($this->method() == 'PUT') {
            $rules['email'] = 'required|string|email|max:255|unique:users,id,:id';
        }

        return $rules;
    }
}
