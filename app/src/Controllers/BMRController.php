<?php

namespace App\Controllers;

use App\Exceptions\HttpNoDataProvidedException;
use App\Services\BMRService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BMRController extends BaseController
{
    public function __construct(private BMRService $bmr_service) {}

    public function handleGetBMR(Request $request, Response $response): Response
    {
        // Info to do computations on from the request body
        $data = $request->getParsedBody();

        if (isset($data) && !empty($data)) {
            //Update athlete using athletes service
            $result = $this->bmr_service->CalculateBMR($request, $data);
            $payload = [];
            //TODO Could implement the STATUS_CODE constants interface
            if ($result->isSuccess()) {
                //Prepare a successful response
                $payload["success"] = true;
                $payload["status"] = 200;
                $payload["message"] = $result->getMessage();
            } else {
                //Prepare a failed response
                $payload["success"] = false;
                $payload["status"] = 400;
                $payload["errors"] = $result->getErrors();
            }
        } else {
            //! If no data was provided, throw an error
            throw new HttpNoDataProvidedException($request);
        }

        return $this->renderJson($response, $payload, $payload["status"]);
    }
}
