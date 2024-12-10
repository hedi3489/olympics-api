<?php

namespace App\Services;

use App\Core\Result;

class BMRService extends BaseService
{
    public function CalculateBMR($request, $data): Result
    {
        //* Validate through Valitron
        // Calling custom function for dynamic Valitron validation
        $this->executeValitron($request, $data);

        // If athlete exists, delete it from the database
        if ($athlete) {
            $this->athlete_model->deleteAthlete($data);
            // Return success Result with updated data
            return Result::success("Athlete {$data['athlete_id']} deleted successfully!");
        } else {
            // Handle any database errors and return a fail Result
            return Result::fail("Database error: Unable to delete athlete. Athlete with id {$data['athlete_id']} doesn't exists.");
        }
        //TODO
        return ($mass / ($height * $height));
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
