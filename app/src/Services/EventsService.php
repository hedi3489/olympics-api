<?php

namespace App\Services;

use App\Core\Result;
use App\Exceptions\HttpNotFoundException;
use App\Models\VenueModel;
use App\Models\EventModel;
use Slim\Exception\HttpBadRequestException;

class EventsService extends BaseService
{
    public function __construct(private VenueModel $venue_model, private EventModel $event_model) {}


    /**
     * Creates new events to insert into the database.
     * @param $request - the http request object for exception handling.
     * @param $data - the properties for creating a event(s) object(s).
     * @return \App\Core\Result - The result of the operation (success/fail).
     */
    public function createEvent($request, $data) : Result
    {
        // Preparing validation rules for each event property
        $this->executeValitron($request, $data);

        // Validating existence of a venue_id FK in the database
        $venue = $this->venue_model->getVenueById($data['venue_id']);
        if($venue==NULL){
            throw new HttpNotFoundException(
                $request,
                "Venue id provided does not exist in the database.
                Please provide an existing venue id or add a new venue first.
                Venue id should a positive integer."
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

    /**
     * Updates an existing event in the database.
     * @param $request - the http request object for exception handling.
     * @param $data - the properties for updating a event row.
     * @return \App\Core\Result - The result of the operation (success/fail).
     */
    public function updateEvent($request, $data) : Result
    {
        // Calling custom function for dynamic Valitron validation
        $this->executeValitron($request, $data);

        // Retrieve event id for where clause
        $where = ["event_id" => $data['event_id']];
        // Getting event before updating it
        $previous_data = $this->event_model->getEventById($where['event_id']);
        if($previous_data==NULL){
            throw new HttpNotFoundException(
                $request,
                "Event id provided does not exist in the database.
                Please provide an existing event id or add a new event first.
                Event id should a positive integer."
            );
        }
        // Verifying if venue_id FK is in database
        $venue = $this->venue_model->getVenueById($data['venue_id']);
        if($venue==NULL){
            throw new HttpNotFoundException(
                request: $request,
                message:"Venue id provided does not exist in the database. Please provide an existing venue id or add a new venue first. Venue id should a positive integer."
            );
        }

        // Define the update:
        $data = [
            'event_name' => $data['event_name'] ?? $previous_data['event_name'],
            'event_sport' => $data['event_sport'] ?? $previous_data['event_sport'],
            'start_date' => $data['start_date'] ?? $previous_data['start_date'],
            'end_date' => $data['end_date'] ?? $previous_data['end_date'],
            'number_of_participants' => $data['number_of_participants'] ?? $previous_data['number_of_participants'],
            'is_paralympic' => $data['is_paralympic'] ?? $previous_data['is_paralympic'],
            'venue_id' => $data['venue_id'] ?? $previous_data['venue_id']
        ];

        // If data is valid, update venue
         try {
            // Calling the insert method
            $this->event_model->updateEvent($data, $where);
            //Return success Result with updated data
            return Result::success(
                "Event {$where['event_id']} updated successfully.", $data);

        } catch (\PDOException $e) {
            // Handle any database errors and return a fail Result
            return Result::fail("Database error: Unable to update venue.");
        }
    }

    /**
     * Deletes an existing venue in the database.
     * @param $request - the http request object for exception handling.
     * @param $data - associative array containing 'venue_id'.
     * @return \App\Core\Result - The result of the operation (success/fail).
     */
    public function deleteEvent($request, $data) : Result
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
        $rgx_error = 'must be 30 characters or fewer and can only include letters, digits, and spaces.';
        $current_date = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $method = strtolower($request->getMethod());

        // Valitron does not interrupt the process when a required field is missing,
        // unless $v->validate is run right after assigning the 'required' rule
        $v = new \Valitron\Validator($data);
        if($method === 'post'){
            $v->rule('required', ['event_name','event_sport', 'start_date',
            'end_date', 'number_of_participants', 'is_paralympic', 'venue_id']);
            $this->runValitron($request, $v);
        }
        if ($method === 'put' || $method === 'delete'){
            $v->rule('required', ['event_id']);
            $v->rule('integer', 'event_id');
            $v->rule('min','event_id', 1)->message('Event id cannot a negative integer.');
            $this->runValitron($request, $v);
        }
        if($method === 'put'){
            $v->rule('required', ['start_date', 'end_date']);
            $this->runValitron($request, $v);
        }
        if ($method === 'post' || $method === 'put'){
            $v->rule('regex', 'event_name', '/^[a-zA-Z0-9 ]{1,30}$/')->message("Event name $rgx_error");
            $v->rule('regex', 'event_sport', '/^[a-zA-Z0-9 ]{1,30}$/')->message("Event sport $rgx_error");
            $v->rule('integer', 'number_of_participants')->message('The number of participants must be a positive integer.');
            $v->rule('min','number_of_participants', 1)->message('The minimum number of participants cannot be less than 1.');
            $v->rule('max','number_of_participants', 100000)->message('The maximum number of participants cannot be more than 100000.');
            $v->rule('integer', 'venue_id')->message('The venue_id must be a positive integer.');
            $v->rule('min','venue_id', 1)->message('The venue_id cannot be less than 1.');
            $v->rule('boolean', 'is_paralympic');
            $v->rule('date', ['start_date', 'end_date'])->message('Date format must be YYYY-MM-DD');
            $v->rule('dateBefore', 'start_date', $data['end_date'])->message("the start date '{$data['start_date']}' cannot be after the end date '{$data['end_date']}'.");
            $v->rule('dateBefore', 'start_date', $tomorrow)->message("The start_date '{$data['start_date']}' cannot be after the current date '$current_date'.");
            $v->rule('dateBefore', 'end_date', $tomorrow)->message("The end_date '{$data['end_date']}' cannot be after the current date '$current_date'.");

        }

        $this->runValitron($request, $v);
    }
}

