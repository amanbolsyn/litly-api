<?php

namespace App\Http\Requests\Api\v1\Author;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorReqeust extends FormRequest
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
            'fullname' => ['required', 'string'],
            'biography' => ['nullable', 'string'],
            'languages' => ['array'],
            'languages.*' => ['nullable', 'string', 'distinct'],
            'date_of_birth' => ['nullable', 'date'],
            'date_of_death' => ['nullable', 'date'],
        
            'images.portrait' => ['array', 'max:5'],
            'images.portrait.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
}
