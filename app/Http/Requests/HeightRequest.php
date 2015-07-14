<?php
/**
 * Request for Role
 */
namespace App\Http\Requests;
use Lang;

class HeightRequest extends Request {

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
            'height_value'=>'required|unique:height|digits_between:1,111',

        ];
    }

    public function attributes()
    {
        return[
            'height_value' => Lang::get('messages.height_value'),

        ];

    }

}

