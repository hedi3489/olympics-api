<?php

namespace App\Controllers;

use App\Exceptions\HttpNoDataProvidedException;
use App\Models\EventModel;
use App\Services\EventsService;
use App\Validation\ValidationHelper;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class EventController extends BaseController
{
    public function __construct(private EventModel $event_model, private EventsService $events_service)
    {
        parent::__construct();
    }

    public function handleGetEvents(Request $request, Response $response): Response
    {
        // Retrieve the set of parameters.
        $req_params = $request->getQueryParams();

        // Overriding the default pagination if specified in the request.
        $current_page = $req_params["current_page"] ?? 1;
        $page_size = $req_params["page_size"] ?? 15;
        $this->event_model->setPaginationOptions($current_page, $page_size);

        //TODO: Content negotiation

        // Call model to fetch records
        $events = $this->event_model->getEvents($request, $req_params);

        if (empty($events["data"])) {
            // Throw a 404 exception if no events are found
            throw new HttpNotFoundException(
                $request,
                "No matching events were found in the database."
            );
        } else {
            // Encode the events as JSON and send the response
            $payload = json_encode($events);
            $response->getBody()->write($payload);

            return $response
                ->withHeader("Content-Type", "application/json")
                ->withStatus(StatusCodeInterface::STATUS_OK);
        }
    }

    public function handleGetEventById(Request $request, Response $response, array $uri_args): Response
    {
        // Retrieving id from the URI
        (int) $event_id = $uri_args["event_id"];
        // Check if event id was provided
        if (!isset($event_id)) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "No event Id was provided",
                    "hint" => "It must include only numbers between 0-99."
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        // Validate id format
        if (!ValidationHelper::isIntAndInRange($event_id, 0, 99)) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => "400",
                    "message" => "The event Id provided is invalid.",
                    "hint" => "It must include only numbers between 0-99."
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }
        $event = $this->event_model->getEventById($event_id);
        if ($event === false) {
            throw new HttpNotFoundException(
                $request,
                "No matching event Id was found in the database."
            );
        }
        return $this->renderJson($response, $event);
    }



    /**
     * Function that handles the creation and insertion of a new venue
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function handleCreateEvent(Request $request, Response $response): Response
    {
        // Retrieve data of the new resource created from the request body
        $data = $request->getParsedBody();
        if(!isset($data) || empty($data)){
            throw new HttpNoDataProvidedException($request);
        }

        // Create venue using venues service
        $result = $this->events_service->createEvent($request, $data);
        $status_code = 200;
        if ($result->isSuccess()) {
            //Prepare success stmt
            $payload["success"] = true;
        } else {
            $status_code = 400;
            $payload["success"] = false;
        }
        $payload["message"] = $result->getMessage();
        $payload["getData"] = $result->getData();
        $payload["status"] = $status_code;

        return $this->renderJson($response, $payload, $status_code);
    }

    /**
     * Summary of handleUpdateEvent
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleUpdateEvent(Request $request, Response $response) : Response
    {
        // Retrieving the event id to be updated and the update information
        $data = $request->getParsedBody();
        if(!isset($data) || empty($data)){
            throw new HttpNoDataProvidedException($request);
        }
        // Calling updateVenue from service
        $result = $this->events_service->updateEvent($request, $data);
        // Preparing payload
        $status_code = 200;
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

    /**
     * Summary of handleDeleteEvent
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleDeleteEvent(Request $request, Response $response) : Response
    {
        // Retrieve id for where clause
        $data = $request->getParsedBody();
        if(!isset($data) || empty($data)){
            throw new HttpNoDataProvidedException($request);
        }

        // Call DeleteVenue for validation and execution
        $where = ['event_id' => $data["event_id"]];
        $result = $this->events_service->deleteEvent($request, $where);

        // Process response of deleteEvent operation
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
}
