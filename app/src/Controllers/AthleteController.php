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

    public function handleGetAthletes(Request $request, Response $response): Response {
        //* Retrieve the set of parameters.
        $req_params = $request->getQueryParams();

        //* Override the default pagination if specified in the request.
        $current_page = $req_params["current_page"] ?? 1;
        $page_size = $req_params["page_size"] ?? 15;
        $this->athlete_model->setPaginationOptions($current_page, $page_size);

        //* Call to the model to get records with params
        $athletes = $this->athlete_model->getAthletes($req_params);

        if (empty($athletes["data"])) {
            throw new HttpNotFoundException(
                $request,
                "No matching athletes were found in the database."
            );
        } else {
            return $this->renderJson($response, $athletes);
        }
    }

    public function handleGetAthleteById(Request $request, Response $response, array $uri_args): Response {
        $athlete_id = $uri_args["athlete_id"];
        // Make sure athlete_id is provided.
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
