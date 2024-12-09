<?php

namespace App\Services;

use App\Core\Result;
use App\Models\VenueModel;
use Slim\Exception\HttpBadRequestException;

class VenuesService extends BaseService
{
    public function __construct(private VenueModel $venue_model) {}

    /**
     * Creates new venues to insert into the database.
     * @param $request - the http request object for exception handling.
     * @param $data - the properties for creating a venue(s) object(s).
     * @return Result - The result of the operation (success/fail).
     */
    public function CreateVenue($request, $data) : Result
    {
        // Calling custom function for dynamic Valitron validation
        $this->executeValitron($request, $data);

        // If data is valid, insert new venue into the database
        try {
            $last_inserted_id = $this->venue_model->insertVenue($data);

            // Return success Result with inserted row id
            return Result::success("Venue created successfully.", [
                'id' => $last_inserted_id,
                'venue_name' => $data['venue_name'],
                'address' => $data['address'],
                'capacity' => $data['capacity'],
                'type' => $data['type'],
                'date_constructed' => $data['date_constructed'],
                'historical_significance' => $data['historical_significance'],
                'parking_facilities' => $data['parking_facilities']
            ]);

        } catch (\PDOException $e) {
            // Handle any database errors and return a fail Result
            return Result::fail("Database error: Unable to create venue.");
        }
    }

    /**
     * Updates an existing venue in the database.
     * @param $request - the http request object for exception handling.
     * @param $data - the properties for updating a venue row.
     * @return Result - The result of the operation (success/fail).
     */
    public function updateVenue($request, $data) : Result
    {
        // Calling custom function for dynamic Valitron validation
        $this->executeValitron($request, $data);

        // Retrieve venue id for where clause
        $where = ["venue_id" => $data['venue_id']];

        // Getting venue before updating it
        $previous_data = $this->venue_model->getVenueById($where['venue_id']);

        // Define the update:
        $data = [
            'venue_name' => $data['venue_name'] ?? $previous_data['venue_name'],
            'address' => $data['address'] ?? $previous_data['address'],
            'capacity' => $data['capacity'] ?? $previous_data['capacity'],
            'type' => $data['type'] ?? $previous_data['type'],
            'date_constructed' => $data['date_constructed'] ?? $previous_data['date_constructed'],
            'historical_significance' => $data['historical_significance'] ?? $previous_data['historical_significance'],
            'parking_facilities' => $data['parking_facilities'] ?? $previous_data['parking_facilities']
        ];

        // If data is valid, update venue
         try {
            // Calling the insert method
            $this->venue_model->updateVenue($data, $where);
            //Return success Result with updated data
            return Result::success(
                "Venue number {$where['venue_id']} updated successfully.", $data);

        } catch (\PDOException $e) {
            // Handle any database errors and return a fail Result
            return Result::fail("Database error: Unable to update venue.");
        }
    }

    /**
     * Deletes an existing venue in the database.
     * @param $request - the http request object for exception handling.
     * @param $data - associative array containing 'venue_id'.
     * @return Result - The result of the operation (success/fail).
     */
    public function deleteVenue($request, $data) : Result
    {
        // Calling custom function for dynamic Valitron validation
        $this->executeValitron($request, $data);

        // Retrieve venue id for where clause
        $where = ["venue_id" => $data['venue_id']];

        // Verify if venue exists
        $venue = $this->venue_model->getVenueById($where['venue_id']);
        // If no exist, fail
        if(!$venue){
            return Result::fail("Venue {$where['venue_id']} doesn't exist.");
        }else{
            $this->venue_model->deleteVenue($data);
            return Result::success("Venue {$data['venue_id']} Successfully deleted", $data);
        }
    }

    /**
     * Method to write the validation rules since validation will be done in multiple functions.
     * @param $request : used to retrieve the http method for dynamic validation rules & exception handling.
     * @param array $data : the data that to be validated.
     * @return \Valitron\Validator returns a Valitron object.
     */
    private function executeValitron($request, array $data): void
    {
        // Preparing variables for validation
        $rgx_error1 = 'must be 30 characters or fewer and can only include letters, digits, and spaces.';
        $rgx_error2 = 'must be 300 characters or fewer and can only include letters, digits, spaces, commas, and periods.';
        $current_date = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $method = strtolower($request->getMethod());

        $v = new \Valitron\Validator($data);
        if($method === 'post'){
            $v->rule('required', ['venue_name', 'address', 'capacity', 'type', 'date_constructed']);
            $this->runValitron($request, $v);
        }
        if ($method === 'put' || $method === 'delete'){
            $v->rule('required', ['venue_id']);
            $v->rule('integer', 'venue_id');
            $this->runValitron($request, $v);
        }
        if($method === 'put'){
            $v->rule('optional', ['venue_name', 'address', 'capacity', 'type', 'date_constructed']);
        }
        if ($method === 'post' || $method === 'put'){
            $v->rule('regex', 'venue_name', '/^[a-zA-Z0-9 ]{1,30}$/')->message("Venue name $rgx_error1");
            $v->rule('regex', 'address', '/^[a-zA-Z0-9 ]{1,30}$/')->message("Venue address $rgx_error1");
            $v->rule('regex', 'type', '/^[a-zA-Z0-9 ]{1,30}$/')->message("Venue type $rgx_error1");
            $v->rule('min', 'capacity', 1)->message('The minimum capacity cannot be less than 1.');
            $v->rule('max', 'capacity', 100000)->message('The maximum capacity cannot be more than 100000.');
            $v->rule('date', 'date_constructed')->message('The construction date format must be YYYY-MM-DD.');
            $v->rule('dateBefore', 'date_constructed', $tomorrow)->message("The date of construction '{$data['date_constructed']}' cannot be after the current date '$current_date'.");
            $v->rule('regex', 'historical_significance', '/^[a-zA-Z0-9., ]{1,300}$/')->message("The historical significance text $rgx_error2");
            $v->rule('regex', 'parking_facilities', '/^[a-zA-Z0-9., ]{1,300}$/')->message("The parking facilities text $rgx_error2");
        }
        $this->runValitron($request, $v);
    }
}

