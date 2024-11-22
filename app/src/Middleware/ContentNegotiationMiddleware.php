<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Slim\Http\Response;
use App\Exceptions\HttpUnsupportedMediaTypeException;

class ContentNegotiationMiddleware implements MiddlewareInterface
{
    private array $supportedFormats = ['application/json', '*/*'];

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //* Get the Accept header from the request
        $acceptHeader = $request->getHeaderLine('Accept');
        $requestedFormats = explode(',', $acceptHeader);
        $requestedFormats = array_map('trim', $requestedFormats);

        // Check if any requested format is supported
        $supported = false;
        foreach ($requestedFormats as $format) {
            if (in_array($format, $this->supportedFormats)) {
                $supported = true;
                break;
            }
        }

        // If no supported format is found, return a 415 Unsupported Media Type response
        if (!$supported) {
            throw new HttpUnsupportedMediaTypeException($request);
        }

        // If supported, proceed with the request
        return $handler->handle($request);
    }
}
