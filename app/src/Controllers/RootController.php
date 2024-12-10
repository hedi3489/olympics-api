<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\AppSettings;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class RootController extends BaseController
{
    private const API_NAME = 'olympics-api';

    private const API_VERSION = '1.0.0';

    /**
     * The root resource (that is, /) whose content includes all the resources the Web service exposes
     * along with the full URI for each resource and their respective description all encoded in JSON.
     * @param \Psr\Http\Message\ResponseInterface $response - The respective JSON encoded object.
     * @return \Psr\Http\Message\ResponseInterface - The interface indicating the return type.
     */
    public function handleRootWebService(Request $request, Response $response): Response
    {
        $data = array(
            'api' => self::API_NAME,
            'version' => self::API_VERSION,
            'about' => 'Welcome! This is a Web service that provides information about the 2024 Paris Olympics',
            'authors' => [
                'Daniel Levitin',
                'Hedi Belhassine',
                'Alexandre Cecile'
            ],
            'resources' => [
                'global options' => [
                    'pagination options' => 'current_page, page_size',
                    'ordering options' => 'asc, desc'
                ],
                '/athletes' => [
                    'collection uri' => "localhost/olympics-api/athletes",
                    'singleton uri' => "localhost/olympics-api/athletes/127",
                    'filtering options' => 'country_id, gender, ethnicity',
                    'sorting options' => 'any (validation not implemented)',
                    'ordering & pagination' => 'Implemented',
                    'methods' => 'GET, POST, PUT, DELETE',
                    'implemented by' => 'Daniel Levitin'
                ],
                '/coaches' => [
                    'collection uri' => "localhost/olympics-api/coaches",
                    'singleton uri' => "localhost/olympics-api/coaches/11",
                    'filtering options' => 'gender, sport, been_in_olympics',
                    'sorting options' => 'any (validation not implemented)',
                    'ordering & pagination' => 'Implemented',
                    'methods' => 'GET, POST, PUT, DELETE',
                    'implemented by' => 'Daniel Levitin'
                ],
                '/venues' => [
                    'collection uri' => "localhost/olympics-api/venues",
                    'singleton uri' => "localhost/olympics-api/venues/5",
                    'filtering options' => 'venue_name, min_capacity, max_capacity, min_date_constructed, max_date_constructed',
                    'sorting options' => 'venue_id, venue_name, location, capacity, type, date_constructed, address',
                    'ordering & pagination' => 'Implemented',
                    'methods' => 'GET, POST, PUT, DELETE',
                    'implemented by' => 'Hedi Belhassine'
                ],
                '/events' => [
                    'collection uri' => "localhost/olympics-api/events",
                    'singleton uri' => "localhost/olympics-api/events/19",
                    'filtering options' => 'venue_name, min_capacity, max_capacity, min_date_constructed, max_date_constructed',
                    'sorting options' => 'event_id, event_name, event_sport, start_date, end_date, number_of_participants, is_paralympic, venue_id',
                    'ordering & pagination' => 'Implemented',
                    'methods' => 'GET, POST, PUT, DELETE',
                    'implemented by' => 'Hedi Belhassine'
                ],
                '/results' => [
                    'collection uri' => "localhost/olympics-api/results",
                    'singleton uri' => "Not implemented",
                    'filtering options' => 'Not implemented',
                    'sorting options' => 'Not implemented',
                    'ordering & pagination' => 'Not implemented',
                    'methods' => 'GET, POST(outdated)',
                    'implemented by' => 'Alexandre Cecile'
                ],
                '/countries' => [
                    'collection uri' => "localhost/olympics-api/countries",
                    'singleton uri' => "Not implemented",
                    'filtering options' => 'Not implemented',
                    'sorting options' => 'Not implemented',
                    'ordering & pagination' => 'Not implemented',
                    'methods' => 'GET',
                    'implemented by' => 'Alexandre Cecile'
                ],
            ],
            'computation functionality' => [
                '/bmi' => [
                    'method of access' => 'POST',
                    'function' => 'calculates bmi based on provided data',
                    'required data' => 'gender, age, height, mass',
                    'returned data' => 'bmi, classification',
                    'implemented by' => 'Hedi Belhassine',
                ],
                '/bmr' => [
                    'method of access' => 'POST',
                    'function' => 'calculates bmr based on provided data',
                    'required data' => 'weight, body_fat',
                    'returned data' => 'bmr',
                    'implemented by' => 'Daniel Levitin',
                ]
            ]
        );

        return $this->renderJson($response, $data);
    }
}
