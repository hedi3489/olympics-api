<?php

namespace App\Models;

use App\Core\PDOService;
use App\Validation\ValidationHelper;
use Fig\Http\Message\StatusCodeInterface;
use Slim\Exception\HttpException;


class EventModel extends BaseModel
{
    private string $table_name = "events";

    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Gets all events in the DB
     * @return array - The resulting array of events
     */
    public function getEvents($request, array $req_params): array
    {
        $events = [];
        $query_args = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1";

        $events = (array) $this->paginate($sql, $query_args);
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
     * Gets all events with an event_name
     * @return array - The resulting array of events
     */
    public function getEventsByName($request, array $req_params): array
    {
        $events = [];
        $query_args = [];
        $sql = "SELECT * FROM events WHERE 1";

        //* Filtering by name
        if (isset($req_params["event_name"])) {
            $venue_name = $req_params["event_name"];
            if (empty($venue_name)) {
                throw new HttpException(
                    $request,
                    "No event name was provided",
                    StatusCodeInterface::STATUS_BAD_REQUEST
                );
            } else if (!ValidationHelper::isAlpha($venue_name)) {
                throw new HttpException(
                    $request,
                    "Invalid venue name. Only letters and spaces are allowed",
                    StatusCodeInterface::STATUS_BAD_REQUEST
                );
            } else {
                $sql .= " AND event_name LIKE CONCAT('%', :event_name, '%')";
                $query_args["event_name"] = $req_params['event_name'];
            }
        }

        $events = $this->paginate($sql, $query_args);
        return $events;
    }
}
