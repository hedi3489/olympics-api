<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BMIController
{
    public function handleGetBMI(Request $request, Response $response) : void
    {
        // Validate request body
        $data = $request->getParsedBody();


        // Compute BMI
        $bmi = $this->CalculateBMI($data['mass'], $data['height']);
        $classification = $this->getClassification($bmi, $data['age'], $data['gender']);


        // Return a response
    }


    private function CalculateBMI($mass, $height) : int {
        return  ($mass / ($height * $height));
    }

    private function getClassification($bmi, $age, $gender) : string {
        return "Fatass";
    }

    private function executeValitron($request, array $data): void
    {

        $v = new \Valitron\Validator($data);

        $v->rule('integer', 'age')->message('Age must be an integer.');
        $v->rule('integer', 'mass')->message('Mass must be an integer in Kg.');
        $v->rule('integer', 'height')->message('Height must be an integer in centimeters.');

        $v->rule('min', 'age', 2)->message('Age must be between 2-120 years old.'); // Years
        $v->rule('max', 'age', 120)->message('Age must be between 2-120 years old.'); // Years

        $v->rule('min', 'mass', 2)->message('Mass must be between 2-700 Kg.'); // Kg
        $v->rule('max', 'mass', 700)->message('Mass must be between 2-700 Kg.'); // Kg

        $v->rule('min', 'height', 20)->message('Height must be between 20-200 cm.'); // cm
        $v->rule('max', 'height', 200)->message('Height must be between 20-200 cm.'); // cm



    }
}
