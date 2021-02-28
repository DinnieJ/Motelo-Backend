<?php

namespace App\Http\Requests\RoomComment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCommentRequest extends FormRequest
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
            'id' => 'integer|required|exists:tb_room_comment,id',
            'comment' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => trans('responses.tenant_comment.id.required'),
            'id.integer' => trans('responses.tenant_comment.id.integer'),
            'id.exists' => trans('responses.tenant_comment.id.exists'),

            'comment.required' => trans('responses.tenant_comment.comment.required')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 422));
    }
}
