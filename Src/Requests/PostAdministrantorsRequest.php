<?php
namespace Brand\Standard\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostAdministrantorsRequest extends FormRequest
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
            'username'=> 'required|unique:rbac_users',
            'password'=> 'required',
            'status' => 'required|in:1,2'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名必填' ,
            'username.unique' => '用户已存在',
            'password.required' => '密码必填' ,
            'status.required' => '状态值必填'
        ];
    }
}
