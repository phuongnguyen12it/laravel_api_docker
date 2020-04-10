<?php

namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\FormRequest;
use Illuminate\Http\Request;

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
    public function rules($id = 0)
    {
        $result = [
            'name'             => 'required|max:255',
            'password'         => 'required',
            'phone_number'     => 'required|max:13',
        ];
        if (empty(Request::instance()->id) && empty($id)) {
            $result['email'] = 'required|email|max:255|unique:users';
        }
        return $result;
    }

    public function attributes()
    {
        return [
            'email'         => 'Email address',
            'name'          => 'Name',
            'phone_number'  => 'Phone number',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'This email is exists',
        ];
    }

}
