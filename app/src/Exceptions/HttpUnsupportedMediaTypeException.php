<?php

namespace App\Exceptions;

use Slim\Exception\HttpException;
use Psr\Http\Message\ServerRequestInterface;

class HttpUnsupportedMediaTypeException extends HttpException
{
    public function __construct(
        ServerRequestInterface $request,
        string $message = 'Unsupported Media Type',
        int $code = 415
    ) {
        parent::__construct($request, $message, $code);
        $this->setTitle('Unsupported Media Type');
        $this->setDescription('The server does not support the media type transmitted in the request.');
    }
}
