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

        $results = $this->result_model->getResults([]);

        $payload = json_encode($results);
        $response->getBody()->write($payload);
        return $response->withHeader("content-type", "application/json")->withStatus(200);
	}

    public function handleGetResultById(Request $request, Response $response): Response {
        return $response;
    }

    public function handleCreateResult(Request $request, Response $response): Response {
        $this->result_model->insertResult($request->getParsedBody());

        return $response->withStatus(201);
        

    }

    public function handleUpdateResult(Request $request, Response $response): Response {
        return $response;
    }

}