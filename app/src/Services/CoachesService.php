<?php

namespace App\Services;

use App\Core\Result;
use App\Models\CoachModel;
use Slim\Exception\HttpBadRequestException;

class CoachesService
{
    public function __construct(private CoachModel $coach_model) {}

    /**
     * Creates new coach to insert into the database.
     * @param $request - the http request object for exception handling.
     * @param $data - the properties for creating an athlete object.
     * @return Result - The result of the operation (success/fail).
     */
    public function CreateCoach($request, $data): Result
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
                'date_of_birth' => $data['date_of_birth'],
                'been_in_olympics' => $data['been_in_olympics'],
                'sport' => $data['sport'],
            ]);
        } catch (\PDOException $e) {
            // Handle any database errors and return a fail Result
            return Result::fail("Database error: Unable to create athlete.");
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
        $method = strtolower($request->getMethod());

        $v = new \Valitron\Validator($data);
        if ($method === 'post') {
            $v->rule('required', ['coach_name', 'gender', 'been_in_olympics', 'sport']);
        }

        $v->rule('regex', 'coach_name', '/^[a-zA-Z ]{1,30}$/')->message("Coach name $rgx_error1");
        $v->rule('in', 'gender', ['Male', 'Female'])->message("The gender must be Male or Female.");
        $v->rule('date', 'date_of_birth')->message("The date of birth must be in a valid date format.");
        $v->rule('in', 'been_in_olympics', [0, 1])->message("The value determining if a coach is an olympian must be 0 or 1.");
        $v->rule('regex', 'sport', '/^[a-zA-Z ]{1,30}$/')->message("The sport $rgx_error1");

        if (!$v->validate()) {
            $errors = json_encode($v->errors());
            throw new HttpBadRequestException(
                $request,
                "Invalid data: $errors"
            );
        }
    }
}
