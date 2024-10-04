<?php

namespace App\Controllers;

use App\Models\EventModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EventController extends BaseController
{
    public function __construct(private EventModel $event_model)
    {
        parent::__construct();
    }

    public function handleGetEvents(Request $request, Response $response): Response
    {
        //* Step 1) Retrieve the set of parameters.
        $req_params = $request->getQueryParams();

        //* By doing this, we're changing the response,
        //* by overriding the default pagination
        //! VALIDATE the received pagination params: current_page, page_size
        $this->event_model->setPaginationOptions(2, 15);

        $events = $this->event_model->getEvents();

        $payload = json_encode($events);
        $response->getBody()->write($payload);
        return $response->withHeader("content-type", "application/json")->withStatus(200);
    }



}
