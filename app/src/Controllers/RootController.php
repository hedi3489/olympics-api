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
            'about' => 'Welcome! This i a Web service that provides this and that...',
            'authors' => 'FrostyBee',
            'resources' => '/blah'
        );

        return $this->renderJson($response, $data);
    }
}
