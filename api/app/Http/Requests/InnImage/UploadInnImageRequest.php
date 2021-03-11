<?php

namespace App\Http\Requests\InnImage;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UploadInnImageRequest extends FormRequest
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
            'images.*' => 'required|mimes:png,jpeg,jpg',
            'inn_id' => 'required|integer|exists:tb_inn,id'
        ];
    }

    public function messages()
    {
        return [
            'images.mimes' => 'Ảnh phải là ở định dạng jpg,jpeg,png',
            'inn_id.required' => 'Không được để trống ID của nhà trọ',
            'inn_id.integer' => 'ID của nhà trọ phải là số nguyên dương',
            'inn_id.exists' => 'ID của nhà trọ không tồn tại'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 422));
    }
}
