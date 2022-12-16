<?php

namespace App\Http\Requests\Admin\Tag;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam name object required the value of article name record Example: {"en": "English article name", "ar": "Arabic article name"}
 * @bodyParam active boolean required the status of tag record
*/
class StoreTag extends FormRequest
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
            "name" => "required",
            'active' => ['required', "boolean"],
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['name'];
        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
        });
    }

    public function messages()
    {
        return [
            "name.required" => "(name) ".get_static_content("field_is_required"),

            "active.required" => "(active) ".get_static_content("field_is_required"),
            "active.boolean" => sprintf("%s %s %s", "(active)", "(0,1)", get_static_content("valid_values")),
        ];
    }

}
