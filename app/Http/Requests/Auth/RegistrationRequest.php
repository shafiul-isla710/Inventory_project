<?php

namespace App\Http\Requests\Auth;


use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    use ApiResponse;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6','max:50'],

            'phone'=>['nullable', 'numeric', 'digits:11'],
            'address'=>['nullable', 'string', 'max:255'],
            'avatar'=>['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'=>'Must be filled Name field',
            'email.required'=>'Must be filled Email field',
            'email.email'=>'Email must be a valid email address',
            'email.unique'=>'Email already exists',
            'password.required'=>'Must be filled Password field',
            'password.confirmed'=>'Password confirmation does not match',
        ];
    }
    

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            self::responseWithError( false,'Validation failed', $errors, 422)
        );
    }
}
