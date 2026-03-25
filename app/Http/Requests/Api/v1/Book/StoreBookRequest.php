<?php

namespace App\Http\Requests\Api\v1\Book;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'title' => ['required', 'string', 'unique:books,title'],
            'isbn' => ['required', 'string', 'unique:books,isbn'],
            'description' => ['required', 'string'],
            'publication_year' => ['date'],
            'publisher_id' => ['integer', 'exists:publishers,id'],

            'categories' => ['array'],
            'categories.*' => ['exists:categories,id'],

            'authors' => ['array'],
            'authors.*' => ['exists:authors,id'],

            // 'organizations' => ['array'],
            // 'organizations.*.id' => ['integer', 'exists:organizations,id', 'distinct'],
            // 'orgznizations.*.stock' => ['integer', 'required_with:organizations.*.id'],

        ];
    }
}
