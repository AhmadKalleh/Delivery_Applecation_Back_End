<?php

namespace App\Http\Requests;

use App\Http\Controllers\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CheckVerficationCodeRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'verification_code' => 'required|string|regex:/^\d{6}$/',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator,$this->Validation([],$validator->errors()));
    }
}