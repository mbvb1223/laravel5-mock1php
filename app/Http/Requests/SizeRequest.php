<?php

namespace App\Http\Requests;
use Lang;

class SizeRequest extends Request {

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
            'size_value'=>'required|integer|min:20|max:60|unique:size,size_value,'.$this->get('id'),
        ];
    }

    public function attributes()
    {
        return[
            'height_value' => Lang::get('messages.height_value'),

        ];

    }

}

