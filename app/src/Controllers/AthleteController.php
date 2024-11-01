<?php

namespace App\Controllers;

use App\Models\AthleteModel;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

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

    public function handleGetAthleteById(Request $request, Response $response, array $uri_args): Response {
        $athlete_id = $uri_args["athlete_id"];
        // Check if athlete_id isn't provided.
        if (!isset($athlete_id)) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "No athlete Id was provided",
                    "hint" => "It must be a number above 0."
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }
        $athlete = $this->athlete_model->getAthleteById($athlete_id);
        if ($athlete === false) {
            throw new HttpNotFoundException(
                $request,
                "No athlete matching the provided athlete_id was found in the database."
            );
        }
        return $this->renderJson($response, $athlete);
    }
}
