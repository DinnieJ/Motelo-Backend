<?php

namespace App\Http\Requests\RoomComment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteCommentRequest extends FormRequest
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
            //
            'id' => 'required|integer|exists:tb_room_comment,id'
        ];
    }

    public function messages()
    {
//        return parent::messages(); // TODO: Change the autogenerated stub
        return [
            'id.required' => trans('responses.tenant_comment.id.required'),
            'id.integer' => trans('responses.tenant_comment.id.integer'),
            'id.exists' => trans('responses.tenant_comment.id.exists')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 422));
    }
}