<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ApiException extends Exception
{
    public function __construct(
        public string $errorCode,
        string $message,
        int $status = Response::HTTP_BAD_REQUEST
    ) {
        parent::__construct($message, $status);
    }
}
