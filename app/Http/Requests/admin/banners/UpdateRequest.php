<?php

namespace App\Http\Requests\admin\banners;

use Illuminate\Foundation\Http\FormRequest;

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
            'image' => ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg,webp','max:2048'],
            'type' =>['required','in:store,product'],
            'store_id' => ['required_if:type,store', 'integer', 'exists:stores,id'],
            'product_id' => ['required_if:type,product', 'integer', 'exists:products,id'],
            'ordering' => ['required','integer'],
            'status' => ['required','in:0,1'],
        ];
    }
}
