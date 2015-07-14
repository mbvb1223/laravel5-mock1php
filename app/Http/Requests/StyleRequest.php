<?php
/**
 * Request for Role
 */
namespace App\Http\Requests;

use Lang;

class StyleRequest extends Request {

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
            'style_name'=>'required|unique:style',

        ];
    }

    public function attributes()
    {
        return[
            'style_name' => Lang::get('messages.style_name'),

        ];

    }

}

