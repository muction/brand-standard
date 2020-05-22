<?php namespace Brand\Standard\Exceptions;

use Brand\Standard\Response\Error;
use Throwable;

class BrandNotFoundException extends \Exception
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
        parent::__construct( Error::REQUEST_NOT_FOUND_MSG,Error::REQUEST_NOT_FOUND_CODE );
    }
}
