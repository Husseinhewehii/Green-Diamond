<?php

namespace App\Http\Requests\Admin\User;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class DeleteUser extends FormRequest
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
            //
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if($this->user->isSuperAdmin()){
                validate_single($validator, 'user', get_static_content("you_cannot_delete_user_type_superadmin"));
            };
        });
    }
}
