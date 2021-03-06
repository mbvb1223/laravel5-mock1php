<?php
/**
 * Request for Role
 */
namespace App\Http\Requests;

use Lang;

class RoleRequest extends Request {

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
            'rolename'=>'required|unique:role',

        ];
    }

    public function attributes()
    {
        return[
            'rolename' => Lang::get('messages.roles_rolename'),

        ];

    }

}

