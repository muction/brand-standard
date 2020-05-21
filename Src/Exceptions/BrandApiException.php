<?php namespace Brand\Standard\Exceptions;

use Throwable;

class BrandApiException extends \Exception
{
    /**
     * BrandApiException constructor.
     * @param string $message
     * @param int $code
     * @param string $requestId
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, $requestId = "", Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
