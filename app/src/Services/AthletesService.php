<?php

namespace App\Services;

use App\Core\Result;
use App\Models\AthleteModel;
use Slim\Exception\HttpBadRequestException;

class AthletesService extends BaseService
{
    public function __construct(private AthleteModel $athlete_model) {}

    /**
     * Creates new athlete to insert into the database.
     * @param $request - the http request object for exception handling.
     * @param $data - the properties for creating an athlete object.
     * @return Result - The result of the operation (success/fail).
     */
    public function createAthlete($request, $data): Result
    {
        //* Validate through Valitron
        // Calling custom function for dynamic Valitron validation
        // If data is invalid, an exception will be thrown
        $this->executeValitron($request, $data);

        // If data is valid, insert new athlete into the database
        try {
            $last_inserted_id = $this->athlete_model->insertAthlete($data);

            // Return success Result with inserted data or any relevant ID
            return Result::success("Athlete created successfully!", [
                'athlete_id' => $last_inserted_id,
                'athlete_name' => $data['athlete_name'],
                'country_id' => $data['country_id'],
                'gender' => $data['gender'],
                'sport' => $data['sport'],
                'date_of_birth' => $data['date_of_birth'] ?? null, // nullable because not always available
                'height' => $data['height'],
                'weight' => $data['weight'],
                'ethnicity' => $data['ethnicity'],
                'is_paralympic' => $data['is_paralympic'],
                'gold_medals' => $data['gold_medals'],
                'silver_medals' => $data['silver_medals'],
                'bronze_medals' => $data['bronze_medals'],
                'total_medals' => $data['total_medals']
            ]);
        } catch (\PDOException $e) {
            // Handle any database errors and return a fail Result
            return Result::fail("Database error: Unable to create athlete. Make sure all fields exist and that foreign keys' values exist in referenced tables.");
        }
    }

    /**
     * Updates existing athlete information from the database.
     * @param mixed $request - The http request object for exception handling.
     * @param mixed $data - The properties for updating an athlete object.
     * @return \App\Core\Result - The result of the operation (success/fail).
     */
    public function updateAthlete($request, $data): Result
    {
        //* Validate through Valitron
        // Calling custom function for dynamic Valitron validation
        $this->executeValitron($request, $data);

        $where = ["athlete_id" => $data['athlete_id']];
        $previous_data = $this->athlete_model->getAthleteById($data['athlete_id']);
        $data = [
            'athlete_name' => $data['athlete_name'] ?? $previous_data['athlete_name'],
            'country_id' => $data['country_id'] ?? $previous_data['country_id'],
            'gender' => $data['gender'] ?? $previous_data['gender'],
            'sport' => $data['sport'] ?? $previous_data['sport'],
            'date_of_birth' => $data['date_of_birth'] ?? $previous_data['date_of_birth'],
            'height' => $data['height'] ?? $previous_data['height'],
            'weight' => $data['weight'] ?? $previous_data['weight'],
            'ethnicity' => $data['ethnicity'] ?? $previous_data['ethnicity'],
            'is_paralympic' => $data['is_paralympic'] ?? $previous_data['is_paralympic'],
            'gold_medals' => $data['gold_medals'] ?? $previous_data['gold_medals'],
            'silver_medals' => $data['silver_medals'] ?? $previous_data['silver_medals'],
            'bronze_medals' => $data['bronze_medals'] ?? $previous_data['bronze_medals'],
            'total_medals' => $data['total_medals'] ?? $previous_data['total_medals']
        ];

        // If data is valid, update existing athlete from the database
        try {
            $this->athlete_model->updateAthlete($data, $where);

            // Return success Result with updated data
            return Result::success("Athlete updated successfully!", $data);
        } catch (\PDOException $e) {
            // Handle any database errors and return a fail Result
            return Result::fail("Database error: Unable to update athlete. Make sure all specified fields exist and that foreign keys' values exist in referenced tables.");
        }
    }

    /**
     * Deletes existing athlete from the database.
     * @param mixed $request - The http request object for exception handling.
     * @param mixed $data - The athlete id to delete.
     * @return \App\Core\Result - The result of the operation (success/fail).
     */
    public function deleteAthlete($request, $data): Result
    {
        //* Validate through Valitron
        // Calling custom function for dynamic Valitron validation
        $this->executeValitron($request, $data);

        $where = ["athlete_id" => $data['athlete_id']];
        $athlete = $this->athlete_model->getAthleteById($data['athlete_id']);

        // If athlete exists, delete it from the database
        if ($athlete) {
            $this->athlete_model->deleteAthlete($data);
            // Return success Result with updated data
            return Result::success("Athlete {$data['athlete_id']} deleted successfully!");
        } else {
            // Handle any database errors and return a fail Result
            return Result::fail("Database error: Unable to delete athlete. Athlete with id {$data['athlete_id']} doesn't exists.");
        }
    }

    /**
     * Method to write the validation rules since validation will be done in multiple functions.
     * @param $request | used to retrieve the http method for dynamic validation rules.
     * @param array $data | The athlete that will be validated.
     * @return \Valitron\Validator returns a Valitron object.
     */
    private function executeValitron($request, array $data): void
    {
        $rgx_error1 = 'must be 30 characters or fewer and can only include letters and spaces.';
        $rgx_error2 = 'must be 60 characters or fewer and can only include letters and spaces.';
        $not_num_error = " must be a numeric value.";
        $neg_num_error = " must be 1 or more.";
        $method = strtolower($request->getMethod());

        $v = new \Valitron\Validator($data);
        if ($method === 'post') {
            $v->rule('required', ['athlete_name', 'country_id', 'gender', 'sport', 'height', 'weight', 'ethnicity', 'is_paralympic', 'gold_medals', 'silver_medals', 'bronze_medals', 'total_medals']);
            $this->runValitron($request, $v);
        }
        if ($method === "put" || $method === "delete") {
            $v->rule('required', ['athlete_id']);
            $v->rule('integer', 'athlete_id');
            $v->rule('min', 'athlete_id', 1);
            $this->runValitron($request, $v);
        }
        if ($method === "put") {
            $v->rule('optional', ['athlete_name', 'country_id', 'gender', 'sport', 'date_of_birth', 'height', 'weight', 'ethnicity', 'is_paralympic', 'gold_medals', 'silver_medals', 'bronze_medals', 'total_medals']);
        }
        if ($method === "post" || $method === "put") {
            $v->rule('regex', 'athlete_name', '/^[a-zA-Z ]{1,30}$/')->message("Athlete name $rgx_error1");
            $v->rule('min', 'country_id', 1)->message("The country id $neg_num_error");
            $v->rule('in', 'gender', ['Male', 'Female'])->message("The gender must be Male or Female.");
            $v->rule('regex', 'sport', '/^[a-zA-Z ]{1,30}$/')->message("The sport $rgx_error1");
            $v->rule('date', 'date_of_birth')->message("The date of birth must be in a valid date format.");
            $v->rule('min', 'height', 1)->message("The height $neg_num_error");
            $v->rule('min', 'weight', 1)->message("The weight $neg_num_error");
            $v->rule('regex', 'ethnicity', '/^[a-zA-Z ]{1,60}$/')->message("The ethnicity $rgx_error2");
            $v->rule('in', 'is_paralympic', [0, 1])->message("The value determining if a player is a paralympian must be 0 or 1.");
            $v->rule('numeric', 'gold_medals')->message("The gold medals amount $not_num_error");
            $v->rule('numeric', 'silver_medals')->message("The silver medals amount $not_num_error");
            $v->rule('numeric', 'bronze_medals')->message("The bronze medals amount $not_num_error");
            $v->rule('numeric', 'total_medals')->message("The total medals amount $not_num_error");
        }
        $this->runValitron($request, $v);
    }
}
