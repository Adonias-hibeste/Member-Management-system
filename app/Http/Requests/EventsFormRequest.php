<?php

namespace App\Http\Requests;

use App\Rules\TimeValidation;
use Illuminate\Foundation\Http\FormRequest;

class EventsFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules= [
            'name'=>[
                'required',
               'String',
            ],
           
           'description'=>[
                'required',
               
           ],
           'image'=>[
            'nullable',
               'mimes:jpeg,jpg,png,gif',
           ],
          
        ];
        return $rules;
    }
}
