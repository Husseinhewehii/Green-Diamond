<?php

namespace App\Http\Requests\Admin\StaticContent;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam text object required the value of static content record Example: {"en": "English Static Content", "ar": "Arabic Static Content"}
*/

class UpdateStaticContent extends FormRequest
{
    use ValidationTrait;
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
            "text" => "required",
        ];
    }

    public function messages()
    {
        return [
            "text.required" => "(text) ".get_static_content("field_is_required"),
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['text'];

        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
        });
    }
}
