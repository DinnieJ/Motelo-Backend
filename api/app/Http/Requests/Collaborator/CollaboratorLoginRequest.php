<?php

namespace App\Http\Requests\Collaborator;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CollaboratorLoginRequest extends FormRequest
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
            'email' => 'required|email|exists:tb_collaborator,email',
            'password' => 'required|min:8'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('responses.auth.email.required'),
            'email.exists' => trans('responses.auth.email.exists'),
            'email.email' => trans('responses.auth.email.email'),
            'password.required' =>  trans('responses.auth.password.required'),
            'password.min' => trans('responses.auth.password.min')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 422));
    }
}
