<?php
namespace Brand\Standard\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Brand\Standard\Response\ResponseTrait;

class CategoryRequest extends FormRequest
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
            'title'=> 'required',
            'summary'=> 'required',
            'parent_id'=> 'required',
            'data_type'=> 'required',
            'order'=> 'required',
            'status' => 'required|in:1,2'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '分类名必填' ,
            'summary.required' => '简介必填' ,
            'parent_id.required' => '父级别必填',
            'data_type.required' => '数据类型必填',
            'order.required' => '排序必填',
            'status.required' => '状态必填',
        ];
    }
}
