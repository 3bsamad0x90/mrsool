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
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'gender' => ['nullable', 'string', 'in:male,female'],
            'device_token' => ['nullable', 'string'],
            'lat' => ['required'],
            'lng' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => trans('api.PleaseEnterYourName'),
            'email.required' => trans('api.PleaseEnterYourEmail'),
            'name.max' => trans('api.NameMustBeLessThan255Characters'),
            'phone.required' => trans('api.PleaseEnterYourPhone'),
            'gender.in' => trans('api.PleaseEnterValideGender'),
            'lat.required' => trans('api.PleaseEnterLatitude'),
            'lat.required' => trans('api.PleaseEnterLongitude '),
        ];
    }
}
