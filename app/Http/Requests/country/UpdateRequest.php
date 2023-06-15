<?php

namespace App\Http\Requests\country;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name_ar' => ['required', 'string', 'max:255', Rule::unique('countries')->ignore($this->country)],
            'name_en' => ['required', 'string', 'max:255', Rule::unique('countries')->ignore($this->country)],
            'iso' => ['required', 'string', 'max:2', Rule::unique('countries')->ignore($this->country)],
            'iso3' => ['required', 'string', 'max:3', Rule::unique('countries')->ignore($this->country)],
            'phone_code' => ['required', 'string', 'max:255', Rule::unique('countries')->ignore($this->country)],
            'max_number' => ['required', 'string', 'max:255'],
            'flag' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
