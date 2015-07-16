<?php

namespace App\Http\Requests;

use Lang;

class ImportInvoiceRequest extends Request {

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
            'product_id'=>'required',
            'color_id'=>'required',


        ];
    }

    public function attributes()
    {
        return[
            'category_name' => Lang::get('messages.category_name'),

        ];

    }

}

