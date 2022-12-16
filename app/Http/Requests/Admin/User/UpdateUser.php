<?php

namespace App\Http\Requests\Admin\User;

use App\Constants\UserTypes;
use App\Models\User;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam first_name string the first name of user record must be at 3 characters min and 40 max. Example: Scott
 * @bodyParam last_name string the last name of user record must be at 3 characters min and 40 max. Example: Derek
 * @bodyParam type integer the type of user record must be equals 2 which is the admin type. Example: 2
 * @bodyParam active boolean the status of user record
 * @bodyParam email email the email of user record must be unique. Example: abc@abc.com
 * @bodyParam phone number the phone of user record must be unique. Example: +0121231233
 * @bodyParam password string the password of user record must contain at least 1 special character, 1 number and 1 uppercase letter. Example: AR@plqwe12
 * @bodyParam role_ids array the roles of user. Example: [1,2,3]
*/

class UpdateUser extends FormRequest
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
            "first_name" => constant('valid_name'),
            "last_name" => constant('valid_name'),
            // "email" => ["unique:users,email,".$this->user->id, ...constant('valid_email')],
            // "phone" => ["unique:users,phone,".$this->user->id, "numeric"],
            "email" => constant('valid_email'),
            "phone" => "numeric",
            "type" => "in:".UserTypes::ADMIN,
            "active" => "boolean",
            "password" => constant("valid_password"),
            "role_ids" => "array"
        ];
    }

    public function messages()
    {
        return [
            "first_name.min" => sprintf("%s (%s) %s", "(first name)", constant("min_name_limit"), get_static_content("min_character_limit")),
            "first_name.max" => sprintf("%s (%s) %s", "(first name)", constant("max_name_limit"), get_static_content("max_character_limit")),
            "first_name.string" => "(first name) ".get_static_content("format_is_incorrect"),

            "last_name.min" => sprintf("%s (%s) %s", "(last name)", constant("min_name_limit"), get_static_content("min_character_limit")),
            "last_name.max" => sprintf("%s (%s) %s", "(last name)", constant("max_name_limit"), get_static_content("max_character_limit")),
            "last_name.string" => "(last name) ".get_static_content("format_is_incorrect"),

            "email.unique" => sprintf("%s %s","(email)", get_static_content("field_already_exists")),
            "email.regex" => "(email) ".get_static_content("format_is_incorrect"),

            "phone.unique" => sprintf("%s %s","(phone)", get_static_content("field_already_exists")),
            "phone.numeric" => "(phone) ".get_static_content("must_be_numeric"),

            "type.in" => sprintf("%s (%s) %s", "(type)", UserTypes::ADMIN, get_static_content("valid_values")),

            "active.boolean" => sprintf("%s %s %s", "(active)", "(0,1)", get_static_content("valid_values")),

            "password.regex" => "(password) ".get_static_content("format_is_incorrect"),

            "role_ids.array" => sprintf("%s %s", "(Role IDs)", get_static_content("format_is_incorrect"))
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(User::where('id', '!=', $this->user->id)->where('email', $this->email)->exists()){
                validate_single($validator, 'email', sprintf("%s %s", "(email)", get_static_content("field_already_exists")));
            }
            if(User::where('id', '!=', $this->user->id)->where('phone', $this->phone)->exists()){
                validate_single($validator, 'phone', sprintf("%s %s", "(phone)", get_static_content("field_already_exists")));
            }
            validate_role_ids($validator, $this->role_ids);
        });
    }
}
