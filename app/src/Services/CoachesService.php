<?php

namespace App\Services;

use App\Core\Result;
use App\Models\CoachModel;
use Slim\Exception\HttpBadRequestException;

class CoachesService extends BaseService
{
    public function __construct(private CoachModel $coach_model) {}

    /**
     * Creates new coach to insert into the database.
     * @param $request - the http request object for exception handling.
     * @param $data - the properties for creating a coach object.
     * @return Result - The result of the operation (success/fail).
     */
    public function createCoach($request, $data): Result
    {
        //* Validate through Valitron
        // Calling custom function for dynamic Valitron validation
        $this->executeValitron($request, $data);
        // If data is invalid, an exception will be thrown

        // If data is valid, insert new coach into the database
        try {
            $last_inserted_id = $this->coach_model->insertCoach($data);

            // Return success Result with inserted data or any relevant ID
            return Result::success("Coach created successfully!", [
                'coach_id' => $last_inserted_id,
                'coach_name' => $data['coach_name'],
                'gender' => $data['gender'],
                'date_of_birth' => $data['date_of_birth'] ?? null, // nullable because not always available
                'been_in_olympics' => $data['been_in_olympics'],
                'sport' => $data['sport'],
            ]);
        } catch (\PDOException $e) {
            // Handle any database errors and return a fail Result
            return Result::fail("Database error: Unable to create coach.");
        }
    }

    /**
     * Updates existing coach information from the database.
     * @param mixed $request - The http request object for exception handling.
     * @param mixed $data - The properties for updating an coach object.
     * @return \App\Core\Result - The result of the operation (success/fail).
     */
    public function updateCoach($request, $data): Result
    {
        //* Validate through Valitron
        // Calling custom function for dynamic Valitron validation
        $this->executeValitron($request, $data);

        $where = ["coach_id" => $data['coach_id']];
        $previous_data = $this->coach_model->getCoachById($data['coach_id']);
        $data = [
            'coach_name' => $data['coach_name'] ?? $previous_data['coach_name'],
            'gender' => $data['gender'] ?? $previous_data['gender'],
            'date_of_birth' => $data['date_of_birth'] ?? $previous_data['date_of_birth'],
            'been_in_olympics' => $data['been_in_olympics'] ?? $previous_data['been_in_olympics'],
            'sport' => $data['sport'] ?? $previous_data['sport'],
        ];

        // If data is valid, update existing coach from the database
        try {
            $this->coach_model->updateCoach($data, $where);
            // Return success Result with updated data
            return Result::success("Coach {$where['coach_id']} updated successfully!", $data);
        } catch (\PDOException $e) {
            // Handle any database errors and return a fail Result
            return Result::fail("Database error: Unable to create coach.");
        }
    }

    /**
     * Deletes existing coach from the database.
     * @param mixed $request - The http request object for exception handling.
     * @param mixed $data - The coach id to delete.
     * @return \App\Core\Result - The result of the operation (success/fail).
     */
    public function deleteCoach($request, $data): Result
    {
        //* Validate through Valitron
        // Calling custom function for dynamic Valitron validation
        $this->executeValitron($request, $data);

        $where = ["coach_id" => $data['coach_id']];
        $coach = $this->coach_model->getCoachById($data['coach_id']);

        // If coach exists, delete it from the database
        if ($coach) {
            $this->coach_model->deleteCoach($data);
            // Return success Result with updated data
            return Result::success("Coach {$data['coach_id']} deleted successfully!");
        } else {
            // Handle any database errors and return a fail Result
            return Result::fail("Database error: Unable to delete coach. Coach with id {$data['coach_id']} doesn't exists.");
        }
    }

    /**
     * Method to write the validation rules since validation will be done in multiple functions.
     * @param $request | used to retrieve the http method for dynamic validation rules.
     * @param array $data | The coach that will be validated.
     * @return \Valitron\Validator returns a Valitron object.
     */
    private function executeValitron($request, array $data): void
    {
        $rgx_error1 = 'must be 30 characters or fewer and can only include letters and spaces.';
        $method = strtolower($request->getMethod());

        $v = new \Valitron\Validator($data);
        if ($method === 'post') {
            $v->rule('required', ['coach_name', 'gender', 'been_in_olympics', 'sport']);
            $this->runValitron($request, $v);
        }
        if ($method === "put" || $method === "delete") {
            $v->rule('required', ['coach_id']);
            $v->rule('integer', 'coach_id');
            $v->rule('min', 'coach_id', 1);
            $this->runValitron($request, $v);
        }
        if ($method === "put") {
            $v->rule('required', ['coach_id']);
            $v->rule('optional', ['coach_name', 'gender', 'date_of_birth', 'been_in_olympics', 'sport']);
        }
        if ($method === "post" || $method === "put") {
            $v->rule('regex', 'coach_name', '/^[a-zA-Z ]{1,30}$/')->message("Coach name $rgx_error1");
            $v->rule('in', 'gender', ['Male', 'Female'])->message("The gender must be Male or Female.");
            //TODO Currently if date is invalid it still inserts but with all 0s
            $v->rule('date', 'date_of_birth')->message("The date of birth must be in a valid date format.");
            $v->rule('in', 'been_in_olympics', [0, 1])->message("The value determining if a coach is an olympian must be 0 or 1.");
            $v->rule('regex', 'sport', '/^[a-zA-Z ]{1,30}$/')->message("The sport $rgx_error1");
        }
        $this->runValitron($request, $v);
    }
}
