<?php

namespace App\Http\Requests\Admin\Partition;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam title object the value of partition title record Example: {"en": "English partition title", "ar": "Arabic partition title"}
 * @bodyParam sub_title object the value of partition sub_title record Example: {"en": "English partition sub_title", "ar": "Arabic partition sub_title"}
 * @bodyParam description object the value of partition description record Example: {"en": "English partition description", "ar": "Arabic partition description"}
 * @bodyParam short_description object the value of partition short description record Example: {"en": "English partition short description", "ar": "Arabic partition short description"}
 * @bodyParam active boolean the status of partition record
 * @bodyParam photo file The image of the article. Maximum size is 5MB and allowed types are JPG, JPEG, PNG.
*/
class UpdatePartition extends FormRequest
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
            "title" => "array",
            "group" => constant("valid_name"),
            "sub_title" => "array",
            "description" => "array",
            "short_description" => "array",
            'photo' => constant('valid_image'),
            "active" => "boolean",
        ];
    }

    public function messages()
    {
        return [
            "group.required" =>"(group) ". get_static_content("field_is_required"),
            "group.min" => sprintf("%s (%s) %s", "(group)", constant("min_name_limit"), get_static_content("min_character_limit")),
            "group.max" => sprintf("%s (%s) %s", "(group)", constant("max_name_limit"), get_static_content("max_character_limit")),
            "group.string" => "(group) ".get_static_content("format_is_incorrect"),

            "photo.max" => sprintf("%s (%s) %s", "(photo)", constant("max_image_size"), get_static_content("file_maximum_size")),
            "photo.mimes" => sprintf("%s (%s) %s", "(photo)", valid_inputs(constant("valid_image_mimes")), get_static_content("valid_file_types")),

            "active.boolean" => sprintf("%s %s %s", "(active)", "(0,1)", get_static_content("valid_values")),
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['title', 'sub_title', "description", "short_description"];

        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
        });
    }
}
