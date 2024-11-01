<?php

namespace App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpNotFoundException extends HttpSpecializedException
{
    protected $code = 404;
    protected $message = "Resource not found.";
    protected $title = "404 Not Found.";
    protected $description = "The requested resource could not be found. Please verify the URI and try again.";
}
