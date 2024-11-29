<?php

namespace App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpUnsupportedMediaTypeException extends HttpSpecializedException
{
    protected $code = 415;
    protected $message = "Request header contains unsupported media types.";
    protected string $title = "Unsupported Media Type";
    protected string $description = "Currently, the only supported media type is 'application/json'.";
}
