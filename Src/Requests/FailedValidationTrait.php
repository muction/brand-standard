<?php
namespace Brand\Standard\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait FailedValidationTrait
{
    /**
     * 验证失败时，不进行跳转，而是抛出异常
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            $this->responseValidatorError( $validator->errors() ))
        );
    }
}
