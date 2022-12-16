<?php

namespace App\Http\Requests\Admin\Article;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam article_category_id integer the id of article category record must exist article categories table. Example: 2
 * @bodyParam title object the value of article title record Example: {"en": "English article title", "ar": "Arabic article title"}
 * @bodyParam description object the value of article description record Example: {"en": "English article description", "ar": "Arabic article description"}
 * @bodyParam short_description object the value of article short description record Example: {"en": "English article short description", "ar": "Arabic article short description"}
 * @bodyParam active boolean the status of article category record
 * @bodyParam tag_ids array the tags of article. Example: [1,2,3]
 * @bodyParam photo file The image of the article. Maximum size is 5MB and allowed types are JPG, JPEG, PNG.
 * @bodyParam media_gallery array An array of files each is the video or image of the article. Maximum size is 5MB and allowed types are JPG, JPEG, PNG.
*/
class UpdateArticle extends FormRequest
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
            "article_category_id" => "exists:article_categories,id",
            "title" => "array",
            "description" => "array",
            "short_description" => "array",
            'photo' => constant('valid_image'),
            "active" => "boolean",
            "tag_ids" => "array",
            "media_gallery" => "array",
        ];
    }

    public function messages()
    {
        return [
            "article_category_id.exists" => "(Article Category ID) ".get_static_content("values_are_invalid"),

            "photo.max" => sprintf("%s (%s) %s", "(photo)", constant("max_image_size"), get_static_content("file_maximum_size")),
            "photo.mimes" => sprintf("%s (%s) %s", "(photo)", valid_inputs(constant("valid_image_mimes")), get_static_content("valid_file_types")),

            "active.boolean" => sprintf("%s %s %s", "(active)", "(0,1)", get_static_content("valid_values")),

            "tag_ids.array" => sprintf("%s %s", "(Tag IDs)", get_static_content("format_is_incorrect")),
            "media_gallery.array" => sprintf("%s %s", "(Media Gallery Item)", get_static_content("format_is_incorrect"))
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['title', "description", "short_description"];

        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
            validate_tag_ids($validator, $this->tag_ids);
            validate_media_gallery_array($validator, $this->media_gallery);
        });
    }
}
