<?php

namespace App\Http\Requests;
use Lang;

class ColorRequest extends Request {

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
            'color_name'=>'required||unique:color,color_name,'.$this->get('id'),
        ];
    }

    public function attributes()
    {
        return[
            'color_name' => Lang::get('messages.color_name'),

        ];

    }

}

