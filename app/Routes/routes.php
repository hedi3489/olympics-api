<?php

declare(strict_types=1);

use App\Controllers\UserController;
use App\Controllers\EventController;
use App\Controllers\VenueController;
use App\Controllers\AthleteController;
use App\Controllers\BMIController;
use App\Controllers\BMRController;
use App\Controllers\CoachController;
use App\Controllers\CountryController;
use App\Controllers\ResultController;
use App\Controllers\RootController;
use App\Helpers\DateTimeHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return static function (Slim\App $app): void {

    // Routes without authentication check: /login, /token

    //* Route GET /
    $app->get('/', [RootController::class, 'handleRootWebService']);

    //TODO: Route for user resources => not implemented
    $app->post('/register', callable: [UserController::class, 'handleRegister']);
    $app->post('/login', [UserController::class, 'handleGenerateToken']);

    //* Routes for athletes resource
    $app->get('/athletes', [AthleteController::class, 'handleGetAthletes']);
    $app->get('/athletes/{athlete_id}', [AthleteController::class, 'handleGetAthleteById']);
    $app->post('/athletes', [AthleteController::class, 'handleCreateAthlete']);
    $app->put('/athletes', [AthleteController::class, 'handleUpdateAthlete']);
    $app->delete('/athletes', [AthleteController::class, 'handleDeleteAthlete']);

    //* Routes for coaches resource
    $app->get('/coaches', [CoachController::class, 'handleGetCoaches']);
    $app->get('/coaches/{coach_id}', [CoachController::class, 'handleGetCoachById']);
    $app->post('/coaches', [CoachController::class, 'handleCreateCoach']);
    $app->put('/coaches', [CoachController::class, 'handleUpdateCoach']);
    $app->delete('/coaches', [CoachController::class, 'handleDeleteCoach']);

    //* Routes for venues resource
    $app->get('/venues', [VenueController::class, 'handleGetVenues']);
    $app->get('/venues/{venue_id}', [VenueController::class, 'handleGetVenueById']);
    $app->post('/venues', [VenueController::class, 'handleCreateVenue']);
    $app->put('/venues', [VenueController::class, 'handleUpdateVenue']);
    $app->delete('/venues', [VenueController::class, 'handleDeleteVenue']);

    //* Routes for events resource
    $app->get('/events', [EventController::class, 'handleGetEvents']);
    $app->get('/events/{event_id}', [EventController::class, 'handleGetEventById']);
    $app->post('/events', [EventController::class, 'handleCreateEvent']);
    //TODO: Routes to implement
    $app->put('/events', [EventController::class, 'handleUpdateEvent']);
    $app->delete('/events', [EventController::class, 'handleDeleteEvent']);

    //* Routes for results resource
    $app->get('/results', [ResultController::class, 'handleGetResults']);
    $app->get('/results/{result_id}', [ResultController::class, 'handleGetResultById']);
    $app->post('/results', [ResultController::class, 'handleCreateResult']);
    $app->patch('/results/{result_id}', [ResultController::class, 'handleUpdateResult']);

    //* Routes for countries resource
    $app->get('/countries', callable: [CountryController::class, 'handleGetCountries']);

    //* Routes for computation
    $app->post('/bmi', [BMIController::class, 'handleGetBMI']); //* body mass index
    $app->post('/bmr', [BMRController::class, 'handleGetBMR']); //* basal metabolic rate (Katch-McArdle formula)

    //* ROUTE: GET /ping
    $app->get('/ping', function (Request $request, Response $response, $args) {
        $payload = ["greetings" => "Reporting! Hello there!", "now" => DateTimeHelper::now(DateTimeHelper::Y_M_D_H_M),];
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));
        return $response;
    });

    //* ROUTE: GET /log
    $app->get('/log', [VenueController::class, 'handleLog']);
};
