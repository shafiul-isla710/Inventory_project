<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    use ApiResponse;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'email'=>'required|email|exists:users,email',
            // 'password'=>'required',   
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],       
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Must be filled Email field.',
            'email.email' => 'Email must be a valid email address.',
            'email.exists' => 'Email does not exist.',
            'password.required' => 'Must be filled Password field.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            self::responseWithError(false,'Validation failed', $errors, 422)
        );
    } 
}
