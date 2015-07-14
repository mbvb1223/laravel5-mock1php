<?php

namespace App\Http\Requests;

use Lang;

class ProductRequest extends Request {

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
            'key_product'=>'required|unique:product,key_product,'.$this->get('id'),

        ];
    }

    public function attributes()
    {
        return[
            'key_product' => Lang::get('messages.key_product'),

        ];

    }

}

