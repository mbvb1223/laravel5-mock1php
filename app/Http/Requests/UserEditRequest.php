<?php
//UserRequest.php
namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;

class UserEditRequest extends Request {

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
            'username'=>'required',
            'password'=>'',
            'repassword'=>'same:password',
            'email'=>'required',
            'phone'=>'required',
            'status'=>'required',
            'role_id'=>'required',
        ];
    }

    public function attributes()
    {
        return[
            'username' => Lang::get('messages.users_username'),
            'password' => Lang::get('messages.users_password'),
            'email' => Lang::get('messages.users_email'),
            'phone' => Lang::get('messages.users_phone'),
            'avatar' => Lang::get('messages.users_avatar'),
            'status' => Lang::get('messages.users_status'),
            'role_id' => Lang::get('messages.users_role_id'),
            'keyactive' => Lang::get('messages.users_keyactive'),
            'remember_token' => Lang::get('messages.users_remember_token'),
            'created_at' => Lang::get('messages.users_created_at'),
            'updated_at' => Lang::get('messages.users_updated_at'),

        ];

    }

}

