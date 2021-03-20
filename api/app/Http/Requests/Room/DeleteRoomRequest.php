<?php

namespace App\Http\Requests\Room;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteRoomRequest extends FormRequest
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
            'room_id' => 'required|numeric|exists:tb_room,id'
        ];
    }

    public function messages()
    {
        return [
            'room_id.required' => trans('responses.room.id.required'),
            'room_id.numeric' => trans('responses.room.id.numeric'),
            'room_id.exists' => trans('responses.room.id.exists')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 422));
    }
}
