<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ListRoomRequest extends FormRequest
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
            'gender' => ['integer', Rule::in(\App\Models\MstGenderType::all()->pluck('id')->toArray())],
            'room_type' => ['integer', Rule::in(\App\Models\MstRoomType::all()->pluck('id')->toArray())],
            'min_price' => 'numeric',
            'max_price' => 'numeric',
            'features' => ['regex:/^\d+(?:,\d+)*$/',
                function ($attribute, $value, $fail) {
                    $featuresArr = \explode(',', $value);
                    $needle = \App\Models\MstFeatureType::all()->pluck('id')->toArray();
                    $diff = \array_diff($featuresArr, $needle);
                    if (count($diff) != 0) {
                        return $fail(trans('responses.list_room.features.in'));
                    }
                }
            ]
        ];
    }

    public function messages()
    {
        return [
            'gender.integer' => trans('responses.list_room.gender.integer'),
            'gender.in' => trans('responses.list_room.gender.in'),
            'room_type.integer' => trans('responses.list_room.room_type.integer'),
            'room_type.in' => trans('responses.list_room.room_type.in'),
            'min_price.numeric' => trans('responses.list_room.min_price.numeric'),
            'max_price.numeric' => trans('responses.list_room.max_price.numeric'),
            'features.regex' => trans('responses.list_room.features.regex')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 422));
    }
}
