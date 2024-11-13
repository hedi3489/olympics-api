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
    //TODO: Call this method in EventController
    public function CreateEvents($request, $data) : Result
    {
        //* Validate through Valitron
        // Preparing validation rules for each event property
        $v = new \Valitron\Validator($data);
        $v->rule('required', ['event_name','event_sport', 'start_date', 'end_date', 'number_of_participants', 'is_paralympic', 'venue_id']);
        $v->rule('regex', 'event_name', '/^[a-zA-Z0-9]+$/')->message('Event name must contain only letters, digits, and spaces');
        $v->rule('regex', 'event_sport', '/^[a-zA-Z0-9]+$/')->message('Event sport must contain only letters, digits, and spaces');
        $v->rule('min','number_of_participants', 0)->message('Minimum number of participants cannot be less than 0');
        $v->rule('max','number_of_participants', 100000)->message('Maximum number of participants cannot be more than 100000');
        $v->rule('date', ['start_date', 'end_date'])->message('Date format must be YYYY-MM-DD');
        $v->rule('dateBefore', 'start_date', 'end_date')->message('the start date cannot be after the end date');
        $v->rule('dateAfter', 'end_date', 'start_date')->message('the end date cannot be before the start date');
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
                "Venue id provided does not exist in the database.\n
                Please provide an existing venue id or add a new venue first.\n
                Venue id should be between 0-99."
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

