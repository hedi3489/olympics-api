<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController extends BaseController
{
    public function handleGenerateToken(Request $request, Response $response) : Response
    {

        //TODO: query DB to authenticate users


        //* authentication success

        //! authentication failure

        $issued_at = time();
        $expires_at = time() + 600; // 10 minutes
        $registered_claims = [
            'iss' => '',
            'aud' => '',
            'iat' => $issued_at,
            'exp' => $expires_at
        ];

        //TODO: registered claims need to be fetched from users table
        $private_claims = [];

        $payload = array_merge($registered_claims, $private_claims);

        $jwt = JWT::encode($payload, SECRET_KEY, 'HS256');
        $jwt_data = [
            "status" => "success",
            "message" => "The token has been generated successfully",
            "token" => $jwt
        ];
        return $this->renderJson($response, $jwt_data);
    }
}
