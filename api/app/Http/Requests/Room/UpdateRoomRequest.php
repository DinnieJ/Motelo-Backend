<?php

namespace App\Http\Requests\Room;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRoomRequest extends FormRequest
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
            'room_id' => 'required|numeric|exists:tb_room,id',
            'title' => 'required',
            'room_type_id' => 'required|integer|exists:mst_room_type,id',
            'price' => 'required|numeric',
            'acreage' => 'required|numeric',
            'description' => 'required',
            'gender_type_id' => 'required|integer|exists:mst_gender_type,id',
            'images' => 'required',
            'images.*' => 'required|mimes:png,jpeg,jpg|max:5000'
        ];
    }

    public function messages()
    {
        return [
            'room_id.required' => trans('responses.room.id.required'),
            'room_id.numeric' => trans('responses.room.id.numeric'),
            'room_id.exists' => trans('responses.room.id.exists'),

            'title.required' => trans('responses.room.title.required'),
            'room_type_id.required' => trans('responses.room.room_type_id.required'),
            'room_type_id.integer' => trans('responses.room.room_type_id.integer'),
            'room_type_id.exists' => trans('responses.room.room_type_id.exists'),
            'price.required' => trans('responses.room.price.required'),
            'price.numeric' => trans('responses.room.price.numeric'),
            'acreage.required' => trans('responses.room.acreage.required'),
            'acreage.numeric' => trans('responses.room.acreage.numeric'),
            'description.required' => trans('responses.room.description.required'),
            'gender_type_id.required' => trans('responses.room.gender_type_id.required'),
            'gender_type_id.integer' => trans('responses.room.gender_type_id.integer'),
            'gender_type_id.exists' => trans('responses.room.gender_type_id.exists'),
            'images.required' => trans('responses.room.images.required')


        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 422));
    }
}
