<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileFormRequest extends FormRequest
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

           'full_address'=>[
                'required',

           ],
           'dob'=>[
            'required',

       ],
           'place_of_birth'=>[
            'required',

       ],
           'image'=>[
            'nullable',
               'mimes:jpeg,jpg,png,gif',
           ],

           'nationality'=>[
            'required',

       ],




   'gender'=>[
    'required',

],
'email'=>[
    'required',

],

  'phone_number'=>[
    'required',

],
'password'=>[
    'required',

],
'membership_type'=>[
    'required',

],
        ];
        return $rules;
    }
}
