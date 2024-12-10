<?php

namespace App\Services;

use App\Core\Result;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BMIService extends BaseService
{
    public function __construct() {}

    public function getBMIResults(Request $request, $data) : Result
    {
        $this->executeValitron($request, $data);

        $bmi = $this->calculateBMI($data['mass'], $data['height']);
        $classification = $this->getClassification($bmi, $data['age'], $data['gender']);
        $payload = [
            'bmi' => $bmi,
            'classification' => $classification
        ];

        // dd($payload);
        // Return a response
        try {
            return Result::success(
                "BMI calculated successfully.", $payload);
        } catch (\PDOException $e) {
            return Result::fail("BMI could not be calculated.");
        }
    }

    private function calculateBMI($mass, $height) : float {
        $height = (float)$height/100;
        $bmi = $mass / ($height * $height);
        return number_format($bmi, 2);
    }

    private function getClassification($bmi, $age, $gender) : string {
        return "Fatass";
    }

    private function executeValitron($request, array $data): void
    {
        // dd($data);
        $v = new \Valitron\Validator($data);

        $v->rule('regex', $data['gender'], '/^[FM]$/')->message("Gender must be 'M' or 'F'.");
        $v->rule('integer', $data['age'])->message('Age must be an integer.');
        $v->rule('integer', $data['mass'])->message('Mass must be an integer in Kg.');
        $v->rule('integer', $data['height'])->message('Height must be an integer in centimeters.');

        $v->rule('min', $data['age'], 2)->message('Age must be between 2-120 years old.'); // Years
        $v->rule('max', $data['age'], 120)->message('Age must be between 2-120 years old.'); // Years

        $v->rule('min', $data['mass'], 2)->message('Mass must be between 2-700 Kg.'); // Kg
        $v->rule('max', $data['mass'], 700)->message('Mass must be between 2-700 Kg.'); // Kg

        $v->rule('min', $data['height'], 20)->message('Height must be between 20-200 cm.'); // cm
        $v->rule('max', $data['height'], 200)->message('Height must be between 20-200 cm.'); // cm

        $this->runValitron($request, $v);
    }
}
