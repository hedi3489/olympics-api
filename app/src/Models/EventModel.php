<?php

namespace App\Models;

use App\Core\PDOService;
use App\Validation\ValidationHelper;
use Fig\Http\Message\StatusCodeInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;

class EventModel extends BaseModel
{
    private string $table_name = "events";

    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Gets all events in the database.
     * @return array - The resulting array of events.
     */
    public function getEvents($request, array $req_params): array
    {
        $events = [];
        $query_args = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1";

        //* Filter by name
        if (isset($req_params["event_name"])) {
            // Validate name
            $event_name = $req_params["event_name"];
            if (ValidationHelper::isNameValid($request, $event_name, "event")) {
                $sql .= "  AND event_name LIKE CONCAT('%', :event_name, '%') ";
                $query_args['event_name'] = $req_params["event_name"];
            }
        }

        // Filter by date

        //* Filter by paralympic
        if (isset($req_params["is_paralympic"])) {
            // Is_paralympic validation
            $is_para = $req_params["is_paralympic"];
            if ($is_para != 0 && $is_para != 1) {
                throw new HttpBadRequestException(
                    $request,
                    "Value provided for is_paralympic was invalid. Value can be either 0 or 1."
                );
            } else {
                $sql .= "  AND is_paralympic = :is_paralympic";
                $query_args['is_paralympic'] = $req_params["is_paralympic"];
            }
        }

        //* Filter by number of participants
        if (isset($req_params["min_participants"])) {
            // Capacity validation
            (int) $par = $req_params["min_participants"];
            if (!ValidationHelper::isIntAndInRange($par, 0, 1000) || $par == NULL) {
                throw new HttpBadRequestException(
                    $request,
                    "Min_participants range value must be a number between 0 and 1000."
                );
            } else if (isset($req_params["max_participants"])) {
                ValidationHelper::minMaxValidation($request, $req_params["min_participants"], $req_params["min_participants"], "int", "participants");
            } else {
                $sql .= " AND capacity >= :min_participants";
                $query_args['min_participants'] = $req_params["min_participants"];
            }
        }
        if (isset($req_params["max_participants"])) {
            // Capacity validation
            (int) $cap = $req_params["max_participants"];
            if (!ValidationHelper::isIntAndInRange($cap, 0, 1000) || $cap == NULL) {
                throw new HttpBadRequestException(
                    $request,
                    "Max_participants range value must be a number between 0 and 1000."
                );
            } else {
                $sql .= " AND capacity <= :max_participants";
                $query_args['max_participants'] = $req_params["max_participants"];
            }
        }

        //* Sorting
        $sort_by = $req_params['sort_by'] ?? 'event_name';
        $order_by = $req_params['order_by'] ?? 'asc';

        // Validate sort field and order
        $valid_sort_fields = ['event_name', 'event_sport', 'start_date', 'end_date', 'number_of_participants', 'is_paralympic'];
        $valid_orders = ['asc', 'desc'];

        if (in_array($sort_by, $valid_sort_fields) && in_array($order_by, $valid_orders)) {
            $sql .= " ORDER BY $sort_by $order_by"; // Append sorting to the query
        } else {
            throw new HttpBadRequestException($request, "Invalid sorting or ordering parameter. ");
        }

        $events = $this->paginate($sql, $query_args);
        return $events;
    }



    /**
     * Get method for path parameter event_id. Fetches a single row based on provided id.
     * @param string $event_id id of the event requested.
     * @return mixed
     */
    public function getEventById(string $event_id): mixed
    {
        $sql = "SELECT * FROM $this->table_name WHERE event_id = :event_id";
        $event = $this->fetchSingle(
            $sql,
            ["event_id" => $event_id]
        );
        return $event;
    }

    /**
     * Method to insert a new event into the database.
     * @param $new_event : new event to be added to the database.
     * @return string|false returns the last inserted id or false.
     */
    public function insertEvent(array $new_event): mixed
    {
        $this->insert($this->table_name, $new_event);
        return $this->lastInsertId();
    }
}
