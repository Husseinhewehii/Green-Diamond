<?php

namespace App\Http\Requests\Admin\Employee;

use App\Constants\EmployeeTypes;
use App\Models\Employee;
use App\Models\User;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam name string the name of employee record must be at 3 characters min and 40 max. Example: Scott
 * @bodyParam position object the value of employee position record Example: {"en": "English employee position", "ar": "Arabic employee position"}
 * @bodyParam description object the value of employee description record Example: {"en": "English employee description", "ar": "Arabic employee description"}
 * @bodyParam type integer the type of employee record must be equals 1 or 2 which is the manager or staff type respectively. Example: 2
 * @bodyParam active boolean the status of employee record
 * @bodyParam photo file The image of the employee. Maximum size is 5MB and allowed types are JPG, JPEG, PNG.
*/

// @bodyParam email email the email of employee record must be unique in users and employees table. Example: abc@abc.com
// @bodyParam phone number the phone of employee record must be unique in users and employees table. Example: +0121231233
// @bodyParam social_media array the social media links of the employee. Example: [https://www.facebook.com/]

class UpdateEmployee extends FormRequest
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
            "name" => constant('valid_name'),
            "position" => "array",
            // "email" => constant('valid_email'),
            // "phone" => "numeric",
            // 'social_media' => "array",
            "type" => "in:".valid_inputs(EmployeeTypes::getEmployeeTypesValues()),
            'description' => "array",
            'photo' => constant('valid_image'),
            "active" => "boolean",
        ];
    }

    public function messages()
    {
        return [
            "name.min" => sprintf("%s (%s) %s", "(name)", constant("min_name_limit"), get_static_content("min_character_limit")),
            "name.max" => sprintf("%s (%s) %s", "(name)", constant("max_name_limit"), get_static_content("max_character_limit")),
            "name.string" => "(name) ".get_static_content("format_is_incorrect"),

            "active.boolean" => sprintf("%s %s %s", "(active)", "(0,1)", get_static_content("valid_values")),

            // "email.regex" => "(email) ".get_static_content("format_is_incorrect"),

            // "phone.numeric" => "(phone) ".get_static_content("must_be_numeric"),

            "type.in" => sprintf("%s (%s) %s", "(type)", valid_inputs(EmployeeTypes::getEmployeeTypesValues()), get_static_content("valid_values")),


            "photo.max" => sprintf("%s (%s) %s", "(photo)", constant("max_image_size"), get_static_content("file_maximum_size")),
            "photo.mimes" => sprintf("%s (%s) %s", "(photo)", valid_inputs(constant("valid_image_mimes")), get_static_content("valid_file_types")),
        ];
    }

    public function withValidator($validator)
    {
        $translatables = ['position', "description"];

        $validator->after(function ($validator) use ($translatables) {
            validate_translatables($validator, $translatables);

            // if(Employee::where('id', '!=', $this->employee->id)->where('email', $this->email)->exists()){
            //     validate_single($validator, 'email', sprintf("%s %s", "(email)", get_static_content("field_already_exists")));
            // }

            // if(User::where('phone', '!=', $this->employee->phone)->where('email', $this->email)->exists()){
            //     validate_single($validator, 'email', sprintf("%s %s", "(email)", get_static_content("field_already_exists")));
            // }

            // if(Employee::where('id', '!=', $this->employee->id)->where('phone', $this->phone)->exists()){
            //     validate_single($validator, 'phone', sprintf("%s %s", "(phone)", get_static_content("field_already_exists")));
            // }

            // if(User::where('email', '!=', $this->employee->email)->where('phone', $this->phone)->exists()){
            //     validate_single($validator, 'phone', sprintf("%s %s", "(phone)", get_static_content("field_already_exists")));
            // }
        });
    }
}
