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
                    'methods' => 'GET, POST, PUT, DELETE'
                ],
                '/coaches' => [
                    'collection uri' => "localhost/olympics-api/coaches",
                    'singleton uri' => "localhost/olympics-api/coaches/11",
                    'filtering options' => 'gender, sport, been_in_olympics',
                    'sorting options' => 'any (validation not implemented)',
                    'methods' => 'GET, POST, PUT, DELETE'
                ],
                '/venues' => [
                    'collection uri' => "localhost/olympics-api/venues",
                    'singleton uri' => "localhost/olympics-api/venues/5",
                    'filtering options' => 'venue_name, min_capacity, max_capacity, min_date_constructed, max_date_constructed',
                    'sorting options' => 'venue_id, venue_name, location, capacity, type, date_constructed, address',
                    'methods' => 'GET, POST, PUT, DELETE'
                ],
                '/events' => [
                    'collection uri' => "localhost/olympics-api/events",
                    'singleton uri' => "localhost/olympics-api/events/19",
                    'filtering options' => 'venue_name, min_capacity, max_capacity, min_date_constructed, max_date_constructed',
                    'sorting options' => 'event_id, event_name, event_sport, start_date, end_date, number_of_participants, is_paralympic, venue_id',
                    'methods' => 'GET, POST, PUT, DELETE'
                ],
            ],
        );

        return $this->renderJson($response, $data);
    }
}
