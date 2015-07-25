<?php

namespace App\Http\Requests;

use Lang;

class AddProductToOrderInBackEndRequest extends Request {

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
            'order_id'=>'required',
            'product_id'=>'required',
            'color_id'=>'required',
            'size_id'=>'required',

        ];
    }

    public function attributes()
    {
        return[


        ];

    }

}

