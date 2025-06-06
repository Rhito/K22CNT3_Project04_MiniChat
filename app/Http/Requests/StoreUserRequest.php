<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:6', 'max:255'],
            'email' => ['required', 'email', 'string', 'max:255', 'unique:users'],
            'avatar' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    /**
     * Override the failed validation to return a JSON response.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'Validation failed',
            'message' => 'The given data was invalid.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
