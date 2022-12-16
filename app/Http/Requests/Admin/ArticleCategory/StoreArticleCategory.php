<?php

namespace App\Http\Requests\Admin\ArticleCategory;

use App\Constants\ArticleCategoriesTypes;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam title object required the value of article category record Example: {"en": "English article category", "ar": "Arabic article category"}
 * @bodyParam type integer required the type of article category record must be equals 1 or 2 which is the blogs or news type respectively. Example: 2
 * @bodyParam active boolean required the status of article category record
 * @bodyParam parent_id integer the parent ID of article category record must exist article categories table. Example: 2
*/

class StoreArticleCategory extends FormRequest
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
            "parent_id" => "nullable|exists:article_categories,id",
            "type" => ["required", "in:".valid_inputs(ArticleCategoriesTypes::getArticleCategoriesTypesValues())],
            "title" => "required",
            // 'photo' => ["required", ...constant('valid_image')],
            "active" => ["required", "boolean"],
        ];
    }

    public function messages()
    {
        return [
            "parent_id.exists" => "(Parent ID) ".get_static_content("values_are_invalid"),

            "type.required" => "(type) ".get_static_content("field_is_required"),
            "type.in" => sprintf("%s (%s) %s", "(type)", valid_inputs(ArticleCategoriesTypes::getArticleCategoriesTypesValues()), get_static_content("valid_values")),

            "title.required" => "(title) ".get_static_content("field_is_required"),

            // "photo.required" => "(photo) ".get_static_content("field_is_required"),
            // "photo.max" => sprintf("%s (%s) %s", "(photo)", constant("max_image_size"), get_static_content("file_maximum_size")),
            // "photo.mimes" => sprintf("%s (%s) %s", "(photo)", valid_inputs(constant("valid_image_mimes")), get_static_content("valid_file_types")),

            "active.required" => "(active) ".get_static_content("field_is_required"),
            "active.boolean" => sprintf("%s %s %s", "(active)", "(0,1)", get_static_content("valid_values")),
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['title'];

        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
        });
    }
}
