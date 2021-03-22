<?php

namespace App\Http\Requests\Collaborator;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCollaboratorRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:tb_collaborator,email',
            'password' => 'required|min:8',
            'phone_number' => 'required',
            'date_of_birth' => 'required|date',
            'identity_number' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('responses.auth.email.required'),
            'email.email' => trans('responses.auth.email.email'),
            'email.unique' => trans('responses.auth.email.unique'),
            'password.required' => trans('responses.auth.password.required'),
            'password.min' => trans('responses.auth.password.min'),
            'date_of_birth.required' => trans('responses.auth.date_of_birth.required'),
            'date_of_birth.date' => trans('responses.auth.date_of_birth.date'),
            'name.required' => trans('responses.auth.name.required'),
            'name.string' => trans('responses.auth.name.string'),
            'name.regex' => trans('responses.auth.name.regex'),
            'phone_number.required' => trans('responses.auth.phone_number.required'),
            'identity_number.required' => trans('responses.auth.identity_number.required')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 422));
    }
}