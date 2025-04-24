<?php

namespace App\Http\Requests\API;

use App\Models\No_of_floors;
use InfyOm\Generator\Request\APIRequest;

class UpdateNo_of_floorsAPIRequest extends APIRequest
{
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
        $rules = No_of_floors::$rules;
        
        return $rules;
    }
}
