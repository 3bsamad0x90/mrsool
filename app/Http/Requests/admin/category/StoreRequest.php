<?php

namespace App\Http\Requests\admin\category;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        $rules = [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'ordering' => 'nullable|integer',
            'mainCategory' => 'nullable|in:0,1',
            'status' => 'nullable|in:active,inactive',
            'parent_id' => 'nullable|exists:categories,id'
        ];
        if ($this->mainCategory == '1') {
            $rules['parent_id'] = 'required|exists:categories,id';
            $rules['description_ar'] = 'required|string|max:255';
            $rules['description_en'] = 'required|string|max:255';
            $rules['cover'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048';
            $rules['start_work'] = 'nullable|date_format:H:i';
            $rules['end_work'] = 'nullable|date_format:H:i';
            $rules['lat'] = 'nullable|numeric';
            $rules['lng'] = 'nullable|numeric';
        }
        return $rules;
    }
}
