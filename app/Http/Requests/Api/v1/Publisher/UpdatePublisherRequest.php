<?php

namespace App\Http\Requests\Api\v1\Publisher;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePublisherRequest extends FormRequest
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
            'publisher' => ['required', 'string', 'unique:publishers,publisher'],
            'images.logo' => ['nullable', 'array'],
            'images.logo.new.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048']
        ];
    }
}
