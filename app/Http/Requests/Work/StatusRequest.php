<?php

namespace App\Http\Requests\Work;

use App\Http\Requests\Request;
use Config;

class StatusRequest extends Request
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
        return [];
        // return [
        //     'status'      => Config::get('validator.status'),
        //     'status_name' => Config::get('validator.status')
        // ];
    }
}
