<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadPlaceImagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isOwner();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'images' => ['required'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }


    public function attributes()
    {
        return [
            'images.*' => trans('attributes.image'),
        ];
    }
}
