<?php

namespace App\Http\Requests;

use App\Http\Controllers\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CheckSignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    use ResponseHelper;
    public function authorize(): bool
    {
        return true;
    }

    /**
     *
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return
        [
            'first_name' =>'required|string|max:50|min:2',
            'last_name' =>'required|string|max:50|min:2',
            'phone_number'=>'required|string|regex:/^\d{10}$/|unique:pending_users,phone_number|unique:users,phone_number',
            'email' =>'required|email|unique:pending_users,email|unique:users,email',
            'password' =>'required|min:6',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator,$this->Validation([],$validator->errors()));
    }
}
