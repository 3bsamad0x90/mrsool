<?php

namespace App\Http\Requests\stores;

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
            'mainStore' => 'nullable|in:0,1',
            'status' => 'nullable|in:active,inactive',
        ];
        if ($this->mainStore == '1') {
            $rules['parent_id'] = 'required|exists:stores,id';
            // $rules['description_ar'] = 'required|string|max:255';
            // $rules['description_en'] = 'required|string|max:255';
            $rules['cover'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048';
            $rules['start_work'] = ['nullable',];
            $rules['end_work'] = ['nullable'];
            $rules['lat'] = 'nullable';
            $rules['lng'] = 'nullable';
        }
        return $rules;
    }
}
