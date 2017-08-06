<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateUserRequest extends Request {

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
     * @cpnwaugha: c-e added regex to validation
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|unique:users|regex:/^[\w]+(\.[\w]+)*(@kdsg\.gov\.ng)+$/i',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed',
        ];
    }

}
