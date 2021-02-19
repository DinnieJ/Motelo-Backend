<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OwnerLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:tb_owner,email',
            'password' => 'required|min:8'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('responses.tenant.email.required'),
            'email.email' => trans('responses.tenant.email.email'),
            'email.exists' => trans('responses.tenant.email.exists'),
            'password.required' => trans('responses.tenant.password.required'),
            'password.min' => trans('responses.tenant.password.min')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
