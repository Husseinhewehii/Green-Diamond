<?php

namespace App\Http\Requests\Admin\Role;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRole extends FormRequest
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
            if($this->role->name == "super-admin"){
                validate_single($validator, 'role', get_static_content("you_cannot_delete_role_superadmin"));
            };
        });
    }
}
