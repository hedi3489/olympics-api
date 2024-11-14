<?php

namespace App\Services;

use App\Core\Result;
use App\Models\VenueModel;
use Slim\Exception\HttpBadRequestException;

class VenuesService
{
    public function __construct(private VenueModel $venue_model, ) {}

    /**
     * Creates new venues to insert into the database.
     * @param $request - the http request object for exception handling.
     * @param $data - the properties for creating a venue(s) object(s).
     * @return Result - The result of the operation (success/fail).
     */
    public function CreateVenue($request, $data) : Result
    {
        //* Validate through Valitron
        // Preparing validation rules for each venue property
        $rgx_error1 = 'must be 30 characters or fewer and can only include letters, digits, and spaces.';
        $rgx_error2 = 'must be 300 characters or fewer and can only include letters, digits, spaces, commas and periods.';
        $current_date = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        $v = new \Valitron\Validator($data);
        $v->rule('required', ['venue_name','address', 'capacity', 'type', 'date_constructed']);
        $v->rule('regex', 'venue_name', '/^[a-zA-Z0-9 ]{1,30}$/')->message("Venue name $rgx_error1");
        $v->rule('regex', 'address', '/^[a-zA-Z0-9 ]{1,30}$/')->message("Venue address $rgx_error1");
        $v->rule('regex', 'type', '/^[a-zA-Z0-9 ]{1,30}$/')->message("Venue type $rgx_error1");
        $v->rule('min','capacity', 1)->message('The minimum capacity cannot be less than 1.');
        $v->rule('max','capacity', 100000)->message('The maximum capacity cannot be more than 100000.');
        $v->rule('date', 'date_constructed')->message('The construction date format must be YYYY-MM-DD.');
        $v->rule('dateBefore', 'date_constructed', $tomorrow)->message("the date of construction '{$data['date_constructed']}' cannot be after the the current date '$current_date'.");
        $v->rule('regex', 'historical_significance', '/^[a-zA-Z0-9., ]{1,300}$/')->message("The historical significance text $rgx_error2");
        $v->rule('regex', 'parking_facilities', '/^[a-zA-Z0-9., ]{1,300}$/')->message("The parking facilities text $rgx_error2");

        //* Fail creation process as early as possible
        if(!$v->validate()){
            $errors = json_encode($v->errors());
            throw new HttpBadRequestException(
                $request,
                "Invalid data: $errors"
            );
        }

        //* If data is valid, insert new venue into the database
        try {
            $last_inserted_id = $this->venue_model->insertVenue($data);

            // Return success Result with inserted data or any relevant ID
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

}

