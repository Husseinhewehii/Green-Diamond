<?php

namespace App\Http\Requests\Admin\Slider;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam group string required the group of slider record must be home_header or partner 3 characters min and 40 max. Example: Editor
 * @bodyParam photo file required The image of the slider. Maximum size is 5MB and allowed types are JPG, JPEG, PNG.
*/
class StoreSlider extends FormRequest
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
            'group' => ["required", ...constant('valid_name'), "in:home_header,partner"],
            'photo' => ["required", ...constant('valid_image')],
        ];
    }

    public function messages()
    {
        return [
            "photo.required" => "(photo) ".get_static_content("field_is_required"),
            "photo.max" => sprintf("%s (%s) %s", "(photo)", constant("max_image_size"), get_static_content("file_maximum_size")),
            "photo.mimes" => sprintf("%s (%s) %s", "(photo)", valid_inputs(constant("valid_image_mimes")), get_static_content("valid_file_types")),

            "group.required" =>"(group) ". get_static_content("field_is_required"),
            "group.min" => sprintf("%s (%s) %s", "(group)", constant("min_name_limit"), get_static_content("min_character_limit")),
            "group.max" => sprintf("%s (%s) %s", "(group)", constant("max_name_limit"), get_static_content("max_character_limit")),
            "group.string" => "(group) ".get_static_content("format_is_incorrect"),
            "group.in" => sprintf("%s (%s) %s", "(group)", "home_header,partner", get_static_content("valid_values")),
        ];
    }
}
