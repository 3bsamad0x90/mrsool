<?php

namespace App\Http\Requests\admin\banners;

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
        return [
            'image' => ['required','image', 'mimes:jpeg,png,jpg,gif,svg,webp','max:2048'],
            'type' =>['required', 'in:store,product'],
            'store_id' => ['required_if:type,store', 'nullable', 'integer', 'exists:stores,id'],
            'product_id' => ['required_if:type,product', 'nullable', 'integer', 'exists:products,id'],
            'ordering' => ['nullable','integer'],
            'status' => ['nullable','in:0,1'],
        ];
    }
}
