<?php

namespace App\Controllers;

use App\Models\ResultModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ResultController extends BaseController
{
	public function __construct(private ResultModel $result_model)
    {
        parent::__construct();
    }


	public function handleGetResults(Request $request, Response $response): Response {

		$req_params = $request->getQueryParams();

        $results = $this->result_model->getResults();

        $payload = json_encode($results);
        $response->getBody()->write($payload);
        return $response->withHeader("content-type", "application/json")->withStatus(200);
	}

}