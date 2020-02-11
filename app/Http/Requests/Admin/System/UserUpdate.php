<?php

namespace App\Http\Requests\Admin\System;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdate extends FormRequest
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
            'name' => 'required|unique:users,name,' . $this->route('user') . '|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('user') . '|max:255',
            'old_password' => 'max:255',
            'password' => 'confirmed|max:255',
        ];
    }


}
