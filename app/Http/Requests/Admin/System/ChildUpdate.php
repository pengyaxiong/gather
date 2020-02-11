<?php

namespace App\Http\Requests\Admin\System;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChildUpdate extends FormRequest
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
        $user_id = Auth::user()->id;
        return [
            'name' => 'required|unique:users,name,' . $user_id . '|max:255',
 //           'email' => 'required|email|unique:users,email,' . $user_id . '|max:255',
            'phone' => 'required|unique:users,phone,' . $user_id . '|max:255',
//            'old_password' => 'max:255',
            'password' => 'confirmed|max:255',
        ];


    }

//    public function messages()
//    {
//        $user_id = Auth::user()->id;
//        return [
//            'name.unique' => $user_id,
//            'email.unique' => $user_id,
//        ];
//
//    }
}
