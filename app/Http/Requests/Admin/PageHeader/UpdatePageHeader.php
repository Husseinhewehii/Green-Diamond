<?php

namespace App\Http\Requests\Admin\PageHeader;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam photo file The image of the page header. Maximum size is 5MB and allowed types are JPG, JPEG, PNG.
*/
class UpdatePageHeader extends FormRequest
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

    public function rules()
    {
        return [
            'photo' => constant('valid_image'),
        ];
    }

    public function messages()
    {
        return [
            "photo.max" => sprintf("%s (%s) %s", "(photo)", constant("max_image_size"), get_static_content("file_maximum_size")),
            "photo.mimes" => sprintf("%s (%s) %s", "(photo)", valid_inputs(constant("valid_image_mimes")), get_static_content("valid_file_types")),
        ];
    }
}
