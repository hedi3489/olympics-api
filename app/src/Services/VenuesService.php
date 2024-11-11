<?php

namespace App\Services;

use App\Core\Result;
use App\Models\VenueModel;
use Slim\Exception\HttpBadRequestException;

class VenuesService
{
    public function __construct(private VenueModel $venue_model, ) {}

    //TODO: Add documentation.


    /**
     * Creates new venues to insert into the database.
     * @param $request - the http request object for exception handling.
     * @param $data - the properties for creating a venue(s) object(s).
     * @return Result - The result of the operation (success/fail).
     */
    public function CreateVenues($request, $data) : Result
    {
        //* Validate through Valitron
        // Preparing validation rules for each venue property
        $v = new \Valitron\Validator($data);
        $v->rule('required', ['venue_name','address', 'capacity', 'type', 'date_constructed']);
        $v->rule('regex', 'venue_name', '/^[a-zA-Z0-9\s]+$/')->message('Venue name must contain only letters, digits, and spaces');
        $v->rule('regex', 'address', '/^[a-zA-Z0-9\s]+$/')->message('Venue address must contain only letters, digits, and spaces');
        $v->rule('regex', 'type', '/^[a-zA-Z0-9\s]+$/')->message('Venue type must contain only letters, digits, and spaces');
        $v->rule('min','capacity', 0)->message('Minimum capacity cannot be less than 0');
        $v->rule('max','capacity', 100000)->message('Maximum capacity cannot be more than 100000');;
        $v->rule('date', 'date_constructed')->message('Date format must be YYYY-MM-DD');

        // Validation
        if(!$v->validate()){
            $errors = json_encode($v->errors());
            throw new HttpBadRequestException(
                $request,
                "Invalid data: $errors"
            );
        }

        // Step 2: Insert data into the database
        try {
            $last_inserted_id = $this->venue_model->insertVenue($data);

            // Return success Result with inserted data or any relevant ID
            return Result::success("Venue created successfully.", [
                //TODO: Fix fetching id. Look at BaseModel.
                'id' => $last_inserted_id,
                'venue_name' => $data['venue_name'],
                'address' => $data['address'],
                'capacity' => $data['capacity'],
                'type' => $data['type'],
                'constructed_date' => $data['constructed_date'],
                'historical_significance' => $data['historical_significance'],
                'parking_facilities' => $data['parking_facilities']
            ]);

        } catch (\PDOException $e) {
            //TODO: Look at this.
            // Handle any database errors and return a fail Result
            return Result::fail("Database error: Unable to create venue.");
        }
    }

}
