<?php

namespace App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpBadFilterException extends HttpSpecializedException
{
    protected $code = 400;
    protected $message = "Invalid filter provided.";
    protected string $title = "400 Bad Request";
    protected string $description = "Please make sure you provide a valid filter before submitting. Only alphanumeric characters and spaces are allowed.";
}
