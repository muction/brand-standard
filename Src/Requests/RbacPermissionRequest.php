<?php
namespace Brand\Standard\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Brand\Standard\Response\ResponseTrait;
class RbacPermissionRequest extends FormRequest
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
            'type'=> 'required',
            'name'=> 'required',
            'display_name'=> 'required',
            'parent_id'=> 'required' ,
            'order'=> 'required' ,
        ];
    }

    public function messages()
    {
        return [
            'type.required' => '权限类别必填' ,
            'name.required' => '权限名必填' ,
            'display_name.required' => '权限名称必填' ,
            'parent_id.required'=>'父级别必选' ,
            'order.required'=>'排序必须填写' ,
        ];
    }
}
