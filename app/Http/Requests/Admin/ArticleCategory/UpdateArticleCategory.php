<?php

namespace App\Http\Requests\Admin\ArticleCategory;

use App\Constants\ArticleCategoriesTypes;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam title object the value of article category record Example: {"en": "English article category", "ar": "Arabic article category"}
 * @bodyParam type integer the type of article category record must be equals 1 or 2 which is the blogs or news type respectively. Example: 2
 * @bodyParam active boolean the status of article category record
 * @bodyParam parent_id integer the parent ID of article category record must exist article categories table and should not be equal targeted record. Example: 2
*/

class UpdateArticleCategory extends FormRequest
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

    public function rules()
    {
        return [
            "parent_id" => "nullable|exists:article_categories,id",
            "type" => "in:".valid_inputs(ArticleCategoriesTypes::getArticleCategoriesTypesValues()),
            "title" => "",
            // 'photo' => constant('valid_image'),
            "active" => "boolean",
        ];
    }

    public function messages()
    {
        return [
            "parent_id.exists" => "(Parent ID) ".get_static_content("values_are_invalid"),

            "type.in" => sprintf("%s (%s) %s", "(type)", valid_inputs(ArticleCategoriesTypes::getArticleCategoriesTypesValues()), get_static_content("valid_values")),

            // "photo.max" => sprintf("%s (%s) %s", "(photo)", constant("max_image_size"), get_static_content("file_maximum_size")),
            // "photo.mimes" => sprintf("%s (%s) %s", "(photo)", valid_inputs(constant("valid_image_mimes")), get_static_content("valid_file_types")),

            "active.boolean" => sprintf("%s %s %s", "(active)", "(0,1)", get_static_content("valid_values")),
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['title'];

        $validator->after(function ($validator) use ($translatables) {
            if($this->articleCategory->id == $this->parent_id){
                validate_single($validator, "parent_id", "(Parent ID) ".get_static_content("values_should_be_different_from_target_item"));
            }
            validate_translatables($validator, $translatables);
        });
    }
}
