<?php

namespace App\Controllers;

use App\Models\CountryModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CountryController extends BaseController
{
	public function __construct(private CountryModel $country_model)
    {
        parent::__construct();
    }


	public function handleGetCountries(Request $request, Response $response): Response {

		$req_params = $request->getQueryParams();

        $countries = $this->country_model->getCountries();

        $payload = json_encode($countries);
        $response->getBody()->write($payload);
        return $response->withHeader("content-type", "application/json")->withStatus(200);
	}

}