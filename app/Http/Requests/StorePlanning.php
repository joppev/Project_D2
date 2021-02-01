<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanning extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'startdatum' => 'required|before_or_equal:stopdatum',
            'starttijd' => 'required',
            'stopdatum' => 'required',
            'stoptijd' => 'required',
            'user_id' => 'numeric',
            'kade_id' => 'numeric',
            'soort_id' => 'numeric',
            'aantal' => 'required|numeric',
            'ladingdetails' => 'required|min:3|max:255',
            'status' => 'digits:1',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->somethingElseIsInvalid()) {
                $validator->errors()->add('field', 'Something is wrong with this field!');
            }
        });
    }
}
