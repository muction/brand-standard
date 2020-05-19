<?php
namespace Brand\Standard\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RbacRoleRequest extends FormRequest
{
    use FailedValidationTrait ,ResponseTrait;

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
            'name'=> 'required',
            'display_name'=> 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '角色名必填' ,
            'display_name.required' => '角色显示名称必填'
        ];
    }
}
