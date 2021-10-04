<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdateTableRequest extends FormRequest
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
            '*.id' => ['required', 'numeric', 'integer'],
            '*.position.top' => ['required', 'numeric', 'integer'],
            // Has to be leftToSave since there are bugs in frontend while there is only one left property
            '*.position.leftToSave' => ['required', 'numeric'],
        ];
    }
}
