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
        // Define BMI ranges based on age and gender
        $ranges = $this->getBMIRanges($age, $gender);

        // Get BMI based on class
        if ($bmi < $ranges['underweight']) {
            return "Underweight";
        } elseif ($bmi < $ranges['normal']) {
            return "Normal weight";
        } elseif ($bmi < $ranges['overweight']) {
            return "Overweight";
        } else {
            return "Obese";
        }
    }

    private function getBMIRanges($age, $gender) : array {
        if ($age < 18) {
            // Child ranges
            return [
                'underweight' => 15,
                'normal' => 22,
                'overweight' => 25,
            ];
        } elseif ($age >= 65) {
            // Senior ranges
            return [
                'underweight' => 22,
                'normal' => 27,
                'overweight' => 30,
            ];
        } else {
            // Adult ranges
            return [
                'underweight' => 18.5,
                'normal' => 24.9,
                'overweight' => 29.9,
            ];
        }
    }

    private function executeValitron($request, array $data): void
    {
        // dd($data);
        $v = new \Valitron\Validator($data);
        $v->rule('required', ['gender', 'age', 'mass', 'height']);
        $this->runValitron($request, $v);
        // dd($v);
        $v->rule('regex', 'gender', '/^[FM]$/')->message("Gender must be 'M' or 'F'.");
        $v->rule('integer', 'age')->message('Age must be an integer.');
        $v->rule('integer', 'mass')->message('Mass must be an integer in Kg.');
        $v->rule('integer', 'height')->message('Height must be an integer in centimeters.');

        $v->rule('min', 'age', 2)->message('Age must be between 2-120 years old.'); // Years
        $v->rule('max', 'age', 120)->message('Age must be between 2-120 years old.'); // Years

        $v->rule('min', 'mass', 2)->message('Mass must be between 2-700 Kg.'); // Kg
        $v->rule('max', 'mass', 700)->message('Mass must be between 2-700 Kg.'); // Kg

        $v->rule('min', 'height', 20)->message('Height must be between 20-200 cm.'); // cm
        $v->rule('max', 'height', 200)->message('Height must be between 20-200 cm.'); // cm

        $this->runValitron($request, $v);
    }
}
