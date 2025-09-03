<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|min:4|unique:products,name,'.$this->product->id,
            // 'name' => ['required', 'string', 'min:4',Rule::unique('products','name')->ignore($this->product->id)],
            'description' => 'nullable|string|',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     $errors = $validator->errors()->all();
    //     throw new HttpResponseException(
    //         self::responseWithError('Validation failed', $errors, 422)
    //     );
    // }
}
