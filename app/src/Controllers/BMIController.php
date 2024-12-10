<?php

namespace App\Controllers;

use App\Core\Result;
use App\Services\BMIService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class BMIController extends BaseController
{
    public function __construct(private BMIService $bmi_service) {}

    public function handleGetBMI(Request $request, Response $response) : Response
    {
        $data = $request->getParsedBody();
        if(!isset($data)){
            throw new HttpBadRequestException(
                $request,
                "No body was provided"
            );
        }
        $result = $this->bmi_service->getBMIResults($request, $data);

        $status_code = 201;
        if ($result->isSuccess()) {
            $payload["success"] = true;
        } else {
            $status_code = 400;
            $payload["success"] = false;
        }
        $payload["message"] = $result->getMessage();
        $payload["new_venue"] = $result->getData();
        $payload["status"] = $status_code;

        return $this->renderJson($response, $payload, $status_code);
    }

}
