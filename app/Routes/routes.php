<?php

declare(strict_types=1);

use App\Controllers\EventController;
use App\Controllers\VenueController;
use App\Controllers\AthleteController;
use App\Controllers\CoachController;
use App\Controllers\CountryController;
use App\Controllers\ResultController;
use App\Controllers\RootController;
use App\Helpers\DateTimeHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return static function (Slim\App $app): void {

    // Routes without authentication check: /login, /token

    // Routes with authentication
    //* Route GET /
    $app->get('/', [RootController::class, 'handleRootWebService']);


    //* Routes for athletes resource
    $app->get('/athletes', [AthleteController::class, 'handleGetAthletes']);
    $app->get('/athletes/{athlete_id}', [AthleteController::class, 'handleGetAthleteById']);
    $app->post('/athletes', [AthleteController::class, 'handleCreateAthlete']);


    //* Routes for coaches resource
    $app->get( '/coaches', [CoachController::class, 'handleGetCoaches']);
    $app->get('/coaches/{coach_id}', [CoachController::class, 'handleGetCoachById']);


    //* Routes for venues resource
    $app->get('/venues', [VenueController::class, 'handleGetVenues']);
    $app->get('/venues/{venue_id}', [VenueController::class, 'handleGetVenueById']);
    $app->post('/venues', [VenueController::class, 'handleCreateVenue']);


    //* Routes for events resource
    $app->get('/events', [EventController::class, 'handleGetEvents']);
    $app->get('/events/{event_id}', [EventController::class, 'handleGetEventById']);
    $app->post('/events', [EventController::class, 'handleCreateEvent']);


    //* Routes for results resource
    $app->get( '/results', [ResultController::class, 'handleGetResults']);


    //* Routes for countries resource
    $app->get( '/countries', callable: [CountryController::class, 'handleGetCountries']);

    //* ROUTE: GET /ping
    $app->get('/ping', function (Request $request, Response $response, $args) {

        $payload = [
            "greetings" => "Reporting! Hello there!",
            "now" => DateTimeHelper::now(DateTimeHelper::Y_M_D_H_M),
        ];
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));
        return $response;
    });

    //* ROUTE: GET /log
    $app->get('/log', [VenueController::class, 'handleLog']);

};
