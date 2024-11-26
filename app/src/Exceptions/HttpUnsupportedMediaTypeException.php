<?php

namespace App\Exceptions;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpSpecializedException;
use Throwable;

class HttpUnsupportedMediaTypeException extends HttpSpecializedException
{
    protected $code = 415;
    protected $message = "Request header contains unsupported media types.";
    protected string $title = "Unsupported Media Type";
    protected string $description = "Currently, the only supported media type is 'application/json'.";


    // /**
    //  * @param ServerRequestInterface $request
    //  * @param string|null            $message
    //  * @param Throwable|null         $previous
    //  */
    // public function __construct(ServerRequestInterface $request, ?string $message = null, ?Throwable $previous = null)
    // {
    //     if ($message !== null) {
    //         $this->message = $message;
    //     }

    //     parent::__construct($request, $this->message, $this->code, $previous);
    // }
}
