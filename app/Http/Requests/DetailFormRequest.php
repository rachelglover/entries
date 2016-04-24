<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DetailFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //only allow logged in users
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'max' => 'required',
            'dateTime' => 'required|date',
        ];
    }
}
