<?php

namespace App\Controllers;

use App\Models\CoachModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CoachController extends BaseController
{
    public function __construct(private CoachModel $coach_model) {}

    public function handleGetCoaches(Request $request, Response $response): Response {
        return $response->withHeader("Content-Type", "application/json")->withStatus(200);
    }
}
