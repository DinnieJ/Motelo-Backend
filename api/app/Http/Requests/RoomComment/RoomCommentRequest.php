<?php

namespace App\Http\Requests\RoomComment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoomCommentRequest extends FormRequest
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
            'room_id' => 'required|integer|exists:tb_room,id',
            'comment' => 'required'
        ];
    }

    public function messages()
    {
        return [
            //for room_id
            'room_id.required' => trans('responses.tenant_comment.room_id.required'),
            'room_id.integer' => trans('responses.tenant_comment.room_id.integer'),
            'room_id.exists' => trans('responses.tenant_comment.room_id.exists'),

            //for comment
            'comment.required' => trans('responses.tenant_comment.comment.required')


        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 422));
    }
}
