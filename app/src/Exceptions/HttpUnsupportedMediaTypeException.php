<?php

namespace App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpUnsupportedMediaTypeException extends HttpSpecializedException
{
    protected $code = 415;
    protected $message = "'Accept' header MUST be 'application/json'.";
    protected $title = "415 Unsupported Media Type";
    protected $description = "The request contained invalid inputs.";
}
