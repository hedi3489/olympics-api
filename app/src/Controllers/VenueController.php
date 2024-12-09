<?php

namespace App\Controllers;

use App\Exceptions\HttpNoDataProvidedException;
use App\Models\VenueModel;
use App\Services\VenuesService;
use Fig\Http\Message\StatusCodeInterface;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use App\Validation\ValidationHelper;
use Monolog\Handler\StreamHandler;

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

        // Calling model to fetch records
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


    /**
     * Function that handles the creation and insertion of a new venue
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function handleCreateVenue(Request $request, Response $response): Response
    {
        // Retrieve data of the new resource created from the request body
        $data = $request->getParsedBody();
        if(!isset($data) || empty($data)){
            throw new HttpNoDataProvidedException($request);
        }

        // Create venue using venues service
        $result = $this->venues_service->CreateVenue($request, $data);
        $status_code = 201;
        if ($result->isSuccess()) {
            //Prepare success stmt
            $payload["success"] = true;
        } else {
            $status_code = 400;
            $payload["success"] = false;
        }
        $payload["message"] = $result->getMessage();
        $payload["new_venue"] = $result->getData();
        $payload["status"] = $status_code;

        return $this->renderJson($response, $payload, $status_code);
    }

    //? ToBeDebugged
    public function handleUpdateVenue(Request $request, Response $response) : Response
    {
        // Retrieving the venue id to be updated and the update information
        // $venue_id = $uri_args["venue_id"];
        $data = $request->getParsedBody();
        // $venue_id = $data['venue_id'];

        $result = $this->venues_service->updateVenue($request, $data);
        // dd($result);

        $status_code = 201;
        if ($result->isSuccess()){
            $payload["success"] = true;
        } else {
            $status_code = 400;
            $payload["success"] = false;
        }
        $payload["message"] = $result->getMessage();
        $payload["updated_venue"] = $result->getData();
        $payload["status"] = $status_code;
        // dd($payload);
        return $this->renderJson($response, $payload, $status_code);
    }

    public function handleDeleteVenue(Request $request, Response $response) : Response
    {
        // Retrieve if for where clause
        $data = $request->getParsedBody();
        $where = ['venue_id' => $data["venue_id"]];
        // dd($data);

        // Call DeleteVenue for validation and execution
        $result = $this->venues_service->deleteVenue($request, $where);


        // Process response of deleteVenue operation
        $status_code = 200;
        if ($result->isSuccess()){
            $payload["success"] = true;
        } else {
            $status_code = 400;
            $payload["success"] = false;
        }
        $payload["message"] = $result->getMessage();
        $payload["status"] = $status_code;

        return $this->renderJson($response, $payload, $status_code);
    }

    public function handleLog(Request $request, Response $response): Response{

        echo 'Logging process';
        //* Instantiate Logger, passing 'channel name'
        $logger = new Logger('channel_name');

        //* Push stream handler (Monolog)
        $logger->pushHandler(new StreamHandler(APP_LOGS_PATH . '/access.log'));
        $log_record = "Is logging working?";
        $ip_add = $_SERVER['REMOTE_ADDR'];
        $log_record .= $ip_add;
        $extra = $request->getQueryParams();

        $logger->info(
            $log_record,
            $extra
        );

        return $response;

    }
}
