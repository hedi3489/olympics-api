<?php

namespace App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpInternalServerErrorException extends HttpSpecializedException
{
    protected $code = 500;
    protected $message = "Internal server error.";
    protected $title = "500 Internal Server Error.";
    protected $description = "The server has encountered an unexpected situation preventing it from fulfilling it's request.";
}
