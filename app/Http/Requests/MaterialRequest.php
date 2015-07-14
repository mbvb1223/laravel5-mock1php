<?php
/**
 * Request for Role
 */
namespace App\Http\Requests;

use Lang;

class MaterialRequest extends Request {

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
            'material_name'=>'required|unique:material',

        ];
    }

    public function attributes()
    {
        return[
            'material_name' => Lang::get('messages.material_name'),

        ];

    }

}

