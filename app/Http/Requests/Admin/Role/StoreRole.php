<?php

namespace App\Http\Requests\Admin\Role;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam name string required the name of role record must be at 3 characters min and 40 max. Example: Editor
 * @bodyParam active boolean required the status of role record
 * @bodyParam permission_ids array the permissions of role. Example: [1,2,3]
*/
class StoreRole extends FormRequest
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
            "name" => ["required", 'unique:roles', ...constant('valid_name')],
            "active" => ["required", "boolean"],
            "permission_ids" => "array"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "(name) ".get_static_content("field_is_required"),
            "name.min" => sprintf("%s (%s) %s", "(name)", constant("min_name_limit"), get_static_content("min_character_limit")),
            "name.max" => sprintf("%s (%s) %s", "(name)", constant("max_name_limit"), get_static_content("max_character_limit")),
            "name.string" => "(name) ".get_static_content("format_is_incorrect"),
            "name.unique" => sprintf("%s %s","(name)", get_static_content("field_already_exists")),

            "active.required" => "(active) ".get_static_content("field_is_required"),
            "active.boolean" => sprintf("%s %s %s", "(active)", "(0,1)", get_static_content("valid_values")),

            "permission_ids.array" => sprintf("%s %s", "(Permission IDs)", get_static_content("format_is_incorrect"))
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            validate_permission_ids($validator, $this->permission_ids);
        });
    }
}
