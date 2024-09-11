<?php

namespace App\Controllers;

use App\Models\AthleteModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AthleteController extends BaseController
{
    public function __construct(private AthleteModel $athlete_model) {}

    public function handleGetAthletes(Request $request, Response $response): Response
    {
        $req_params = $request->getQueryParams();

        $athletes = $this->athlete_model->getAthletes($req_params);

        $payload = json_encode($athletes);
        $response->getBody()->write($payload);
        return $response->withHeader("Content-Type", "application/json")->withStatus(200);
    }
}
