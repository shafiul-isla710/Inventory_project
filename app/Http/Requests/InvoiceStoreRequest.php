<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class InvoiceStoreRequest extends FormRequest
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
            'customer_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
            'invoice_date' => 'required|date',

            'products' => 'required|array|distinct',
            'products.*' => 'required|exists:products,id|distinct',

            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric|min:1',

            'amount' => 'required|array',
            'amount.*' => 'required|numeric|min:1',

        ];
    }

     public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            self::responseWithError('Validation failed', $errors, 422)
        );
    } 
}
