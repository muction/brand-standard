<?php
namespace Brand\Standard\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Brand\Standard\Response\ResponseTrait;

class BrandArticleRequest extends FormRequest
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
            'tag'=> 'required',
            //'summary'=> 'required',
            'content'=> 'required',
            'order'=> 'required',
            'status' => 'required|in:1,2'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '分类名必填' ,
            'tag.required' => '分类名必填' ,
            //'summary.required' => '简介必填' ,
            'order.required' => '排序必填',
            'status.required' => '状态必填',
        ];
    }
}
