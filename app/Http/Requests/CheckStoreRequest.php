<?php

namespace App\Http\Requests;


use App\Http\Controllers\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CheckStoreRequest extends FormRequest
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
            'name'=>'required|string|max:40|min:2',
            'description'=> 'string',
            'image_path' =>'required|file|mimes:jpeg,png,jpg,gif,svg,ico',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator,$this->Validation([],$validator->errors()));
    }
}
