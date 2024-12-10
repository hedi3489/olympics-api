<?php

declare(strict_types=1);

namespace App\Middleware;

use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Firebase\JWT\JWT;
use LogicException;
use Slim\Exception\HttpUnauthorizedException;
use UnexpectedValueException;

class AAMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        //* 1) Extract the token from the 'Authorization: Bearer <JWT>' request header
        $auth_header = $request->getHeaderLine("Authorization");
        $jwt = str_replace("Bearer ", "", $auth_header);

        try {
            $decoded = JWT::decode($jwt, new Key(SECRET_KEY, 'HS256'));
        } catch (LogicException $e) {
            // errors having to do with environmental setup or malformed JWT Keys
            echo $e->getMessage();
            throw new HttpUnauthorizedException($request, $e->getMessage());
        } catch (UnexpectedValueException $e) {
            //TODO: Throw a custom HTTPSpecializedException
            // errors having to do with JWT signature and claims
            echo $e->getMessage();
            throw new HttpUnauthorizedException($request, $e->getMessage());
        }

        //! DO NOT remove or change the following statements.
        $response = $handler->handle($request);
        return $response;
    }
}
