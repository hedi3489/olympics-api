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
    //* ROUTE: GET /
    $app->get('/', [RootController::class, 'handleRootWebService']);

    //* ROUTE: GET /athletes
    $app->get('/athletes', [AthleteController::class, 'handleGetAthletes']);
    //* ROUTE: GET /athletes/{athlete_id}
    $app->get('/athletes/{athlete_id}', [AthleteController::class, 'handleGetAthleteById']);

    //* ROUTE: GET /coaches
    $app->get( '/coaches', [CoachController::class, 'handleGetCoaches']);
    //* ROUTE: GET /coaches/{coach_id}
    $app->get('/coaches/{coach_id}', [CoachController::class, 'handleGetCoachById']);

    //* ROUTE: GET /countries
    $app->get( '/countries', [CountryController::class, 'handleGetCountries']);

    //* ROUTE: GET /venues
    $app->get('/venues', [VenueController::class, 'handleGetVenues']);
    //* ROUTE: GET /venues/{venue_id}
    $app->get('/venues/{venue_id}', [VenueController::class, 'handleGetVenueById']);

    //* ROUTE: GET /events
    $app->get('/events', [EventController::class, 'handleGetEvents']);
    //* ROUTE: GET /events/{event_id}
    $app->get('/events/{event_id}', [EventController::class, 'handleGetEventById']);

    $app->get( '/results', [ResultController::class, 'handleGetResults']);

    //* ROUTE: GET /ping
    $app->get('/ping', function (Request $request, Response $response, $args) {

        $payload = [
            "greetings" => "Reporting! Hello there!",
            "now" => DateTimeHelper::now(DateTimeHelper::Y_M_D_H_M),
        ];
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));
        return $response;
    });
};
