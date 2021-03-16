<?php

namespace App\Http\Requests\Utility;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUtilityRequest extends FormRequest
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
            'utility_type_id' => 'required|numeric|exists:mst_utility_type,id',
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'utility_type_id.required' => trans('responses.utility.utility_type_id.required'),
            'utility_type_id.numeric' => trans('responses.utility.utility_type_id.numeric'),
            'utility_type_id.exists' => trans('responses.utility.utility_type_id.exists'),
            'title.required' => trans('responses.utility.title.required'),
            'description.required' => trans('responses.utility.description.required'),
            'location.required' => trans('responses.utility.location.required'),
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 422));
    }
}
