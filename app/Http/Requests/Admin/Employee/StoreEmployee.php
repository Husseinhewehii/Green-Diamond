<?php

namespace App\Http\Requests\Admin\Employee;

use App\Constants\EmployeeTypes;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam name string required the name of employee record must be at 3 characters min and 40 max. Example: Scott
 * @bodyParam position object required the value of employee position record Example: {"en": "English employee position", "ar": "Arabic employee position"}
 * @bodyParam description object required the value of employee description record Example: {"en": "English employee description", "ar": "Arabic employee description"}
 * @bodyParam type integer required the type of employee record must be equals 1 or 2 which is the manager or staff type respectively. Example: 2
 * @bodyParam active boolean required the status of employee record
 * @bodyParam photo file required The image of the employee. Maximum size is 5MB and allowed types are JPG, JPEG, PNG.
*/


//@bodyParam email email required the email of employee record must be unique in users and employees table. Example: abc@abc.com
//@bodyParam phone number required the phone of employee record must be unique in users and employees table. Example: +0121231233
//@bodyParam social_media array the social media links of the employee. Example: [https://www.facebook.com/]
class StoreEmployee extends FormRequest
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
            "name" => ["required", ...constant('valid_name')],
            "position" => ["required"],
            // "email" => ["required", "unique:users", "unique:employees", ...constant('valid_email')],
            // "phone" => ["required", "unique:users", "unique:employees", "numeric"],
            // 'social_media' => "array",
            "type" => ["required", "in:".valid_inputs(EmployeeTypes::getEmployeeTypesValues())],
            'description' => ["required"],
            'photo' => ["required", ...constant('valid_image')],
            "active" => ["required", "boolean"],
        ];
    }
    public function messages()
    {
        return [
            "name.required" =>"(name) ". get_static_content("field_is_required"),
            "name.min" => sprintf("%s (%s) %s", "(name)", constant("min_name_limit"), get_static_content("min_character_limit")),
            "name.max" => sprintf("%s (%s) %s", "(name)", constant("max_name_limit"), get_static_content("max_character_limit")),
            "name.string" => "(name) ".get_static_content("format_is_incorrect"),

            "position.required" =>"(position) ". get_static_content("field_is_required"),

            "active.required" =>"(active) ". get_static_content("field_is_required"),
            "active.boolean" => sprintf("%s %s %s", "(active)", "(0,1)", get_static_content("valid_values")),

            // "email.required" =>"(email) ". get_static_content("field_is_required"),
            // "email.unique" => sprintf("%s %s","(email)", get_static_content("field_already_exists")),
            // "email.regex" => "(email) ".get_static_content("format_is_incorrect"),

            // "phone.required" =>"(phone) ". get_static_content("field_is_required"),
            // "phone.unique" => sprintf("%s %s","(phone)", get_static_content("field_already_exists")),
            // "phone.numeric" => "(phone) ".get_static_content("must_be_numeric"),

            "type.required" =>"(type) ". get_static_content("field_is_required"),
            "type.in" => sprintf("%s (%s) %s", "(type)", valid_inputs(EmployeeTypes::getEmployeeTypesValues()), get_static_content("valid_values")),

            "description.required" =>"(description) ". get_static_content("field_is_required"),

            "photo.required" =>"(photo) ". get_static_content("field_is_required"),
            "photo.max" => sprintf("%s (%s) %s", "(photo)", constant("max_image_size"), get_static_content("file_maximum_size")),
            "photo.mimes" => sprintf("%s (%s) %s", "(photo)", valid_inputs(constant("valid_image_mimes")), get_static_content("valid_file_types")),
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['position', "description"];

        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);
        });
    }
}
