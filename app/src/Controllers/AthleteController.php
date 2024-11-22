<?php

namespace App\Controllers;

use App\Exceptions\HttpNoDataProvidedException;
use App\Models\AthleteModel;
use App\Services\AthletesService;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class AthleteController extends BaseController
{
    public function __construct(private AthleteModel $athlete_model, private AthletesService $athletes_service) {}

    /**
     * Handles formatting of all athletes by adding pagination and validation.
     * @param \Psr\Http\Message\ServerRequestInterface $request - The requested formatting
     * @param \Psr\Http\Message\ResponseInterface $response - Object to prepare.
     * @throws \Slim\Exception\HttpNotFoundException - The error thrown upon bad input.
     * @return \Psr\Http\Message\ResponseInterface - The resulting formatted and paginated JSON object.
     */
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

    /**
     * Handles the retrieval of an athlete by their Id
     * @param \Psr\Http\Message\ServerRequestInterface $request - The requested formatting
     * @param \Psr\Http\Message\ResponseInterface $response - Object to populate and format.
     * @param array $uri_args - The requested arg specification, in this case athlete_id.
     * @throws \Slim\Exception\HttpNotFoundException - The error thrown upon record not found in database.
     * @return \Psr\Http\Message\ResponseInterface - The resulting formatted and JSON object.
     */
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

    /**
     * Handles the creation and insertion of a new athlete.
     * @param \Psr\Http\Message\ServerRequestInterface $request | The submitted athlete object.
     * @param \Psr\Http\Message\ResponseInterface $response | Response interface helper
     * @return \Psr\Http\Message\ResponseInterface The appropriate json object.
     */
    public function handleCreateAthlete(Request $request, Response $response): Response {
        // Retrieve data of the new resource to be created from the request body
        $data = $request->getParsedBody();

        if (isset($data) && !empty($data)) {
            //Create athlete using athletes service
            $result = $this->athletes_service->CreateAthlete($request, $data);
            $payload = [];
            //TODO Could implement the STATUS_CODE constants interface
            if ($result->isSuccess()) {
                //Prepare a successful response
                $payload["success"] = true;
                $payload["status"] = 201;
                $payload["data"] = $result->getData();
            } else {
                //Prepare a failed response
                $payload["success"] = false;
                $payload["status"] = 400;
                $payload["errors"] = $result->getErrors();
            }
        } else {
            //! If no data was provided, throw an error
            throw new HttpNoDataProvidedException($request);
        }

        return $this->renderJson($response, $payload, $payload["status"]);
    }
}
