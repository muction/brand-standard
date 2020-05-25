<?php namespace Brand\Standard\Exceptions;

use Brand\Standard\Response\Error;
use Throwable;

class BrandUnauthorizedException extends \Exception
{
    /**
     * BrandApiException constructor.
     * @param string $message
     * @param int $code
     * @param string $requestId
     * @param Throwable|null $previous
     */
    public function __construct()
    {
        parent::__construct( Error::REQUEST_UNAUTHORIZED_MSG,Error::REQUEST_UNAUTHORIZED_CODE );
    }
}
