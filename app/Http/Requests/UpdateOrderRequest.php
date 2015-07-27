<?php

namespace App\Http\Requests;

use Lang;

class UpdateOrderRequest extends Request {

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
            'username'=>'required|unique:users,username,'.$this->get('user_id'),
            'email'=>'required|unique:users,email,'.$this->get('user_id'),

        ];
    }

    public function attributes()
    {
        return[


        ];

    }

}

