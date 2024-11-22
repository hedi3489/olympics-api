<?php

namespace App\Exceptions;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpSpecializedException;
use Throwable;

class HttpNoDataProvidedException extends HttpSpecializedException
{
    protected $code = 400;
    protected $message = "No data was provided.";
    protected string $title = "400 Bad Request";
    protected string $description = "Please make sure you provide the minimally required data before submitting.";
}
