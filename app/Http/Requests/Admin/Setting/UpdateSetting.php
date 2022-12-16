<?php

namespace App\Http\Requests\Admin\Setting;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam value string required the value of static content record
*/

class UpdateSetting extends FormRequest
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
            "value" => "required",
        ];
    }

    public function messages()
    {
        return [
            "value.required" => "(value) ".get_static_content("field_is_required"),
        ];
    }
}
