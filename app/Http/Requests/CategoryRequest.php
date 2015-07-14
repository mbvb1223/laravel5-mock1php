<?php

namespace App\Http\Requests;

use Lang;

class CategoryRequest extends Request {

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
            'category_name'=>'required|unique:category,category_name,'.$this->get('id'),

        ];
    }

    public function attributes()
    {
        return[
            'category_name' => Lang::get('messages.category_name'),

        ];

    }

}

