<?php
/**
 * Request for Role
 */
namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;

class MadeinRequest extends Request {

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
            'madein_name'=>'required|unique:madein',
        ];
    }

    public function attributes()
    {
        return[
            'madein_name' => Lang::get('messages.madein_name'),

        ];

    }

}

