<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Validation\ValidationHelper;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class EventController extends BaseController
{
    public function __construct(private EventModel $event_model)
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

        if (empty($events)) {
            echo "empty json";
            throw new HttpNotFoundException(
                $request,
                "No matching events were found in the database."
            );
        } else {
            $payload = json_encode($events);
            $response->getBody()->write($payload);

            return $response->withHeader("content-type", "application/json")->withStatus(StatusCodeInterface::STATUS_OK);
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
}
