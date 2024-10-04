<?php

namespace App\Controllers;

use App\Models\VenueModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VenueController extends BaseController
{
    public function __construct(private VenueModel $venue_model){}

    public function handleGetVenues(Request $request, Response $response): Response
    {
        $req_params = $request->getQueryParams();

        $venues = $this->venue_model->getVenues($req_params);

        $payload = json_encode($venues);
        $response->getBody()->write($payload);
        return $response->withHeader("Content-Type", "application/json")->withStatus(200);
    }
}
