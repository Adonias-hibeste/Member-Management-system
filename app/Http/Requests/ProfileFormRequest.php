<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
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
        return [
            'name' => [
                'required',
                'string',
            ],
            'full_address' => [
                'required',
            ],
            'dob' => [
                'required',
            ],
            'place_of_birth' => [
                'required',
            ],
            'image' => [
                'required',
                'mimes:jpeg,jpg,png,gif',
            ],
            'nationality' => [
                'required',
            ],
            'gender' => [
                'required',
            ],
            'email' => [
                'required',
            ],
            'phone_number' => [
                'required',
            ],
            'password' => [
                'required',
            ],
            'membership_type' => [
                'required',
            ],
        ];
    }

  }
