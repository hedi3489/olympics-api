<?php

namespace App\Controllers;

use App\Models\CoachModel;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class CoachController extends BaseController
{
    public function __construct(private CoachModel $coach_model) {}

    public function handleGetCoaches(Request $request, Response $response): Response {
        //* Retrieve the set of parameters.
        $req_params = $request->getQueryParams();

        //* Override the default pagination if specified in the request.
        $current_page = $req_params["current_page"] ?? 1;
        $page_size = $req_params["page_size"] ?? 15;
        $this->coach_model->setPaginationOptions($current_page, $page_size);

        //* Call to the model to get records with params
        $coaches = $this->coach_model->getCoaches($req_params);

        if (empty($coaches["data"])) {
            throw new HttpNotFoundException(
                $request,
                "No matching coaches were found in the database."
            );
        } else {
            return $this->renderJson($response, $coaches);
        }
    }

    public function handleGetCoachById(Request $request, Response $response, array $uri_args): Response {
        $coach_id = $uri_args["coach_id"];
        // Make sure coach_id is provided.
        if (!isset($coach_id)) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "No coach Id was provided",
                    "hint" => "It must be a number above 0."
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }
        $coach = $this->coach_model->getCoachById($coach_id);
        if ($coach === false) {
            throw new HttpNotFoundException(
                $request,
                "No coach matching the provided coach_id was found in the database."
            );
        }
        return $this->renderJson($response, $coach);
    }
}
