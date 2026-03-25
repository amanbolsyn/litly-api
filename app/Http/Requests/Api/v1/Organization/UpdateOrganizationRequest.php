<?php

namespace App\Http\Requests\Api\v1\Organization;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationRequest extends FormRequest
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
            'organization' => ['required', 'string', 'unique:organizations,organization'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'allow_purchase' => ['required', 'boolean'],
            'allow_borrow' => ['required', 'boolean'],
            'allow_borrow_days' => ['required', 'integer'],
            'logo' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
}
