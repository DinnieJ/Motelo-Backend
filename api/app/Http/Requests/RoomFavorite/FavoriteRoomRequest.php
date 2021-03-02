<?php

namespace App\Http\Requests\RoomFavorite;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FavoriteRoomRequest extends FormRequest
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
            'room_id' => 'integer|required|exists:tb_room,id'
        ];
    }

    public function messages()
    {
        return [
            'room_id.integer' => trans('responses.favorite.room_id.integer'),
            'room_id.required' => trans('responses.favorite.room_id.required'),
            'room_id.exists' => trans('responses.favorite.room_id.exists')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 422));
    }
}
