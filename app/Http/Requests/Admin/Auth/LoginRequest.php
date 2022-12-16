<?php

namespace App\Http\Requests\Admin\Auth;

use App\Models\User;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

/**
 * @bodyParam email string required The Email of the User.
 * @bodyParam password string required The Password of the User.
*/
class LoginRequest extends FormRequest
{
    use ValidationTrait;

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
            "email" => "required|exists:users,email",
            "password" => "required",
        ];
    }

    public function messages()
    {
        return [
            "email.required" =>"(email) ". get_static_content("field_is_required"),
            "email.exists" => get_static_content("email_or_password_is_incorrect"),
            "password.required" =>"(password) ". get_static_content("field_is_required"),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = User::whereEmail($this->email)->first();
            if (!($user && Hash::check($this->password, $user->password))) {
                validate_single($validator, "email", get_static_content("email_or_password_is_incorrect"));
            }
        });
    }
}
