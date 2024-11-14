<?php

namespace App\Services;

use App\Core\Result;
use App\Models\VenueModel;
use App\Models\EventModel;
use Slim\Exception\HttpBadRequestException;

class EventsService
{
    public function __construct(private VenueModel $venue_model, private EventModel $event_model) {}


    /**
     * Creates new events to insert into the database.
     * @param $request - the http request object for exception handling.
     * @param $data - the properties for creating a event(s) object(s).
     * @return Result - The result of the operation (success/fail).
     */
    public function CreateEvent($request, $data) : Result
    {
        //* Validate through Valitron
        // Preparing validation rules for each event property
        $rgx_error = 'must be 30 characters or fewer and can only include letters, digits, and spaces.';
        $v = new \Valitron\Validator($data);
        $v->rule('required', ['event_name','event_sport', 'start_date', 'end_date', 'number_of_participants', 'is_paralympic', 'venue_id']);
        $v->rule('regex', 'event_name', '/^[a-zA-Z0-9 ]{1,30}$/')->message("Event name $rgx_error");
        $v->rule('regex', 'event_sport', '/^[a-zA-Z0-9 ]{1,30}$/')->message("Event sport $rgx_error");
        $v->rule('integer', 'number_of_participants')->message('The number of participants must be an integer.');
        $v->rule('min','number_of_participants', 1)->message('The minimum number of participants cannot be less than 1.');
        $v->rule('max','number_of_participants', 100000)->message('The maximum number of participants cannot be more than 100000.');
        $v->rule('date', ['start_date', 'end_date'])->message('Date format must be YYYY-MM-DD');
        $v->rule('dateBefore', 'start_date', $data['end_date'])->message("the start date '{$data['start_date']}' cannot be after the end date '{$data['end_date']}'.");
        $v->rule('boolean', 'is_paralympic');
        $venue = $this->venue_model->getVenueById($data['venue_id']);


        // Fail creation process as early as possible
        if(!$v->validate()){
            $errors = json_encode($v->errors());
            throw new HttpBadRequestException(
                $request,
                "Invalid data: $errors"
            );
        }

        // Validating existence of a venue_id FK in the database
        if($venue==NULL){
            throw new HttpBadRequestException(
                $request,
                "Venue id provided does not exist in the database.
                Please provide an existing venue id or add a new venue first.
                Venue id should an integer be between 0-99."
            );
        }


        // If data is valid, insert new event into the database
        try {
            $last_inserted_id = $this->event_model->insertEvent($data);
            // Return success Result with inserted data or any relevant ID
            return Result::success("Venue created successfully.", [
                'id' => $last_inserted_id,
                'event_name' => $data['event_name'],
                'event_sport' => $data['event_sport'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'number_of_participants' => $data['number_of_participants'],
                'is_paralympic' => $data['is_paralympic'],
                'venue_id' => $data['venue_id']
            ]);

        } catch (\PDOException $e) {
            // Handle any database errors and return a fail Result
            return Result::fail("Database error: Unable to create event.");
        }
    }
}

