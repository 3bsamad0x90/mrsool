<?php

namespace App\Http\Requests\api\user;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'dob' => ['nullable', 'string', 'date'],
            'gender' => ['nullable', 'string', 'in:male,female'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp' , 'max:2048'],
            'device_token' => ['nullable', 'string'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => trans('api.PleaseEnterYourName'),
            'email.required' => trans('api.PleaseEnterYourEmail'),
            'name.max' => trans('api.NameMustBeLessThan255Characters'),
            'phone.required' => trans('api.PleaseEnterYourPhone'),
            'dob.date' => trans('api.PleaseEnterValideDate'),
            'gender.in' => trans('api.PleaseEnterValideGender'),
            'image.image' => trans('api.PleaseEnterValideImage'),
            'image.mimes' => trans('api.MimesImage'),
            'image.max' => trans('api.MaximumImageSizeIs2MB'),
        ];
    }
}
