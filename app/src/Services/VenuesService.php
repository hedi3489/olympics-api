<?php

namespace App\Services;

use App\Core\Result;
use App\Models\VenueModel;
use Slim\Exception\HttpBadRequestException;

class VenuesService
{
    public function __construct(private VenueModel $venue_model, ) {}

    //TODO: Add documentation.

    public function CreateVenues($request, $data) : Result
    {
        //TODO: Validate through Valitron
        $is_valid = false;

        $v = new \Valitron\Validator($data);
        $v->rule('required', ['venue_name', 'capacity', 'date_constructed']);
        $v->rule('regex', 'venue_name', '/^[a-zA-Z\s]+$/')->message('Name must contain only letters and spaces');
        $v->rule('min','capacity', 0);
        $v->rule('max','capacity', 100000);
        $v->rule('date', 'date_constructed')->message('Date format must be YYYY-MM-DD');

        if(!$v->validate()){
            $errors = json_encode($v->errors());
            throw new HttpBadRequestException(
                $request,
                "Invalid data: $errors"
            );
        }

        // Step 2: Insert data into the database
        try {
            $this->venue_model->insertVenue($data);

            // Return success Result with inserted data or any relevant ID
            return Result::success("Venue created successfully.", [
                //TODO: Fix fetching id. Look at BaseModel.
                //'id' => $this->venue_model->lastInsertId(),
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
