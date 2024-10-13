<?php

namespace App\Controllers;

use App\Models\VenueModel;
use App\Services\VenuesService;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class VenueController extends BaseController
{
    public function __construct(private VenueModel $venue_model, private VenuesService $venues_service) {}

    public function handleGetVenues(Request $request, Response $response): Response
    {
        $req_params = $request->getQueryParams();

        $venues = $this->venue_model->getVenues($req_params);

        $payload = json_encode($venues);
        $response->getBody()->write($payload);
        return $response->withHeader("Content-Type", "application/json")->withStatus(200);
    }

    public function handleGetVenueById(Request $request, Response $response, array $uri_args): Response
    {
        // Step 1) Retrieve the received ID.
        $venue_id = $uri_args["venue_id"];
        // Step 2) Validate the player id.
        //? Step 2.1) If bad, kill request right away
        if (!isset($venue_id)) {
            //! OPTION 1) Preparing the response ourselves
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "No event ID provided",
                    "hint" => "The event ID must be formulated as follows: P-99999"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        //* Step 2.2) Validate the format of the player id

        //* Step 3) If valid, fetch the player's info from the DB.
        $venue = $this->venue_model->getVenueById($venue_id);
        //* When a request fails, should return error message with info
        if ($venue === false) {
            throw new HttpNotFoundException(
                $request,
                "No matching player found in the DB."
            );
            //* With more complex situations, such as logging an error message, we might want to use the middleware instance rather than throwing a new exception.
        }
        //* Step 4) Prepare a valid JSON response.
        return $this->renderJson($response, $venue);
        // Without the BaseController, we would have to do all of renderJson here.
    }

    public function handleGetVenuesByName(Request $request, Response $response, array $uri_args): Response
    {
        // Retrieve the received venue name.
        $venue_name = $uri_args["venue_name"];

        // validate name
        //? if bad, kill request immediately
        if (!isset($uri_args["venue_name"])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "No venue name provided"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        // name provided? check validity


        $venues = $this->venue_model->getVenuesByName($venue_name);

        //? if venue != found
        if ($venues === false) {
            throw new HttpNotFoundException(
                $request,
                "No matching venue name found."
            );
        }
        return $this->renderJson($response, $venues);

        /*$payload = json_encode($venues);
        $response->getBody()->write($payload);
        return $response->withHeader("Content-Type", "application/json")->withStatus(200);
        */
    }

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
