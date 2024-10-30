<?php

namespace App\Controllers;

use App\Models\VenueModel;
use App\Services\VenuesService;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use App\Validation\ValidationHelper;

class VenueController extends BaseController
{
    public function __construct(private VenueModel $venue_model, private VenuesService $venues_service) {}

    public function handleGetVenues(Request $request, Response $response): Response
    {
        // Retrieve the set of parameters.
        $req_params = $request->getQueryParams();

        // Overriding the default pagination if specified in the request.
        $current_page = $req_params["current_page"] ?? 1;
        $page_size = $req_params["page_size"] ?? 15;

        $this->venue_model->setPaginationOptions($current_page, $page_size);


        //TODO: Content negotiation

        // Call model to fetch records
        $venues = $this->venue_model->getVenues($request, $req_params);

        if (empty($venues["data"])) {
            throw new HttpNotFoundException(
                $request,
                "No matching venues were found in the database."
            );
        } else {
            $payload = json_encode($venues);
            $response->getBody()->write($payload);
            return $response->withHeader("Content-Type", "application/json")->withStatus(StatusCodeInterface::STATUS_OK);
        }
    }

    public function handleGetVenueById(Request $request, Response $response, array $uri_args): Response
    {
        $venue_id = $uri_args["venue_id"];
        // Check if venue id is provided.
        if (!isset($venue_id)) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "No venue Id was provided",
                    "hint" => "It must include only numbers between 0-99."
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        // Validate the format of the player id
        if (!ValidationHelper::isIntAndInRange($venue_id, 0, 999)) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "The venue Id provided is invalid.",
                    "hint" => "It must include only numbers between 0-99."
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }
        $venue = $this->venue_model->getVenueById($venue_id);
        if ($venue === false) {
            throw new HttpNotFoundException(
                $request,
                "No matching venue id was found in the database."
            );
        }
        return $this->renderJson($response, $venue);
    }


    //? To be used in later iterations
    public function handleCreateVenue(Request $request, Response $response): Response
    {
        echo "QUACK!";
        //* Retrieve data of the new resource created from the request body
        $new_venues = $request->getParsedBody();

        //* Create venue using service
        $result = $this->venues_service->CreateVenues($new_venues);
        $status_code = 201;
        if ($result->isSuccess()) {
            //Prepare success stmt
            $payload["success"] = true;
        } else {
            $status_code = 201;
            $payload["success"] = false;
        }
        //$payload["message"] = $result->getMessage();
        $payload["getData"] = $result->getData();
        $payload["status"] = $status_code;

        return $this->renderJson($response, $new_venues, $status_code);
    }
}
