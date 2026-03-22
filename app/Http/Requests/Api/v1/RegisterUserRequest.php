<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
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
            "fullname" => ["required", "string", "max:63"],
            "email" => ["required", "email", "unique:users,email", "max:255"],
            "password" => [
                "required",
                "confirmed",
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
                    ->symbols(),
            ],
        ];
    }

    public function messages()
    {
        return [
            "data.attributes.email.unique" => "Invalid credentials",
        ];
    }
}
