<?php

namespace App\Http\Requests\Inn;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateInnRequest extends FormRequest
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
            'inn_id' => 'required|integer|exists:tb_inn,id',
            'name' => 'required',
            'water_price' => 'required|numeric|gt:0',
            'electric_price' => 'required|numeric|gt:0',
            'wifi_price' => 'required|numeric|gt:0',
            'open_hour' => 'required|integer',
            'open_minute' => 'required|integer',
            'close_hour' => 'required|integer',
            'close_minute' => 'required|integer',
            'address' => 'required',
            'location' => 'required',
            'features' => 'required',
            'features.*' => 'required|integer|exists:mst_feature_type,id',
            'new_images.*' => 'mimes:png,jpeg,jpg|max:5000',
            'delete_images.*' => 'integer|exists:tb_inn_image,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('responses.inn.name.required'),
            'name.unique' => trans('responses.inn.name.unique'),

            'water_price.required' => trans('responses.inn.water_price.required'),
            'water_price.numeric' => trans('responses.inn.water_price.numeric'),
            'water_price.gt' => trans('responses.inn.water_price.gt'),

            'electric_price.required' => trans('responses.inn.electric_price.required'),
            'electric_price.numeric' => trans('responses.inn.electric_price.numeric'),
            'electric_price.gt' => trans('responses.inn.electric_price.gt'),

            'wifi_price.required' => trans('responses.inn.wifi_price.required'),
            'wifi_price.numeric' => trans('responses.inn.wifi_price.numeric'),
            'wifi_price.gt' => trans('responses.inn.wifi_price.gt'),


            'open_hour.required' => trans('responses.inn.open_hour.required'),
            'open_hour.integer' => trans('responses.inn.open_hour.integer'),

            'open_minute.required' => trans('responses.inn.open_minute.required'),
            'open_minute.integer' => trans('responses.inn.open_minute.integer'),

            'close_hour.required' => trans('responses.inn.close_hour.required'),
            'close_hour.integer' => trans('responses.inn.close_hour.integer'),

            'close_minute.required' => trans('responses.inn.close_minute.required'),
            'close_minute.integer' => trans('responses.inn.close_minute.integer'),


            'address.required' => trans('responses.inn.address.required'),

            'location.required' => trans('responses.inn.location.required'),


            'features.required' => trans('responses.inn.features.required'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 422));
    }
}
