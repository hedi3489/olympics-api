<?php

namespace App\Models;

use App\Core\PDOService;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;
use Fig\Http\Message\StatusCodeInterface;
use App\Validation\ValidationHelper;

class VenueModel extends BaseModel
{
    private string $table_name = "venues";

    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Gets all venues in the database.
     * Get filtered venues based on valid parameters.
     * @return array - The resulting array of venues.
     */
    public function getVenues($request, array $req_params): array
    {
        $venues = [];
        $query_args = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1";

        //* Sorting by name
        if (isset($req_params["venue_name"])) {
            // Name validation
            if (ValidationHelper::isNameValid($request, $req_params["venue_name"], "venue")) {
                $sql .= "  AND venue_name LIKE
                CONCAT('%', :venue_name, '%') ";
                $query_args['venue_name'] = $req_params["venue_name"];
            }
        }

        //* Sorting by Capacity Range
        if (isset($req_params["min_capacity"])) {
            // Capacity validation
            (int) $cap = $req_params["min_capacity"];
            if (!ValidationHelper::isIntAndInRange($cap, 0, 100000) || $cap == NULL) {
                throw new HttpBadRequestException(
                    $request,
                    "Min_capacity range value must be a number between 0 and 100000."
                );
            } else if (isset($req_params["max_capacity"])) {
                ValidationHelper::minMaxValidation($request, $req_params["min_capacity"], $req_params["min_capacity"], "int", "capacity");
            } else {
                $sql .= " AND capacity >= :min_capacity";
                $query_args['min_capacity'] = $req_params["min_capacity"];
            }
        }
        if (isset($req_params["max_capacity"])) {
            // Capacity validation
            (int) $cap = $req_params["max_capacity"];
            if (!ValidationHelper::isIntAndInRange($cap, 0, 100000) || $cap == NULL) {
                throw new HttpBadRequestException(
                    $request,
                    "Max_capacity range value must be a number between 0 and 100000."
                );
            } else {
                $sql .= " AND capacity <= :max_capacity";
                $query_args['max_capacity'] = $req_params["max_capacity"];
            }
        }

        //* Sorting by Construction Date Range
        if (isset($req_params["min_date_constructed"])) {
            // Validating Date
            if (ValidationHelper::isDateRangeValid($request, (string) $req_params["min_date_constructed"], "min")) {
                if (isset($req_params["max_date_constructed"])) {
                    ValidationHelper::minMaxValidation($request, $req_params["min_date_constructed"], $req_params["max_date_constructed"], "date", "date_constructed");
                }
                $sql .= " AND date_constructed >= :min_date_constructed";
                $query_args['min_date_constructed'] = $req_params["min_date_constructed"];
            }
        }
        if (isset($req_params["max_date_constructed"])) {
            if (ValidationHelper::isDateRangeValid($request, (string) $req_params["max_date_constructed"], "max")) {
                $sql .= " AND date_constructed <= :max_date_constructed";
                $query_args['max_date_constructed'] = $req_params["max_date_constructed"];
            }
        }

        //* Ordering
        $sort_by = $req_params['sort_by'] ?? 'venue_name';
        $order_by = $req_params['order_by'] ?? 'asc';

        // Validate sort field and order
        $valid_sort_fields = ['venue_name', 'location', 'capacity', 'type', 'date_constructed', 'address'];
        $valid_orders = ['asc', 'desc'];

        if (in_array($sort_by, $valid_sort_fields) && in_array($order_by, $valid_orders)) {
            $sql .= " ORDER BY $sort_by $order_by"; // Append sorting to the query
        } else {
            throw new HttpBadRequestException($request, "Invalid sorting or ordering parameter. ");
        }

        $venues = (array) $this->paginate($sql, $query_args);
        return $venues;
    }

    /**
     * Get method for path parameter venue_id. Fetches a single row based on provided id.
     * @param string $venue_id id of the venue requested.
     * @return mixed
     */
    public function getVenueById(string $venue_id): mixed
    {
        $sql = "SELECT * FROM $this->table_name WHERE venue_id = :venue_id";
        $venue = $this->fetchSingle(
            $sql,
            ["venue_id" => $venue_id]
        );
        return $venue;
    }

    // public function getVenuesByName(string $venue_name): array
    // {
    //     $venues = [];
    //     $sql = "SELECT * FROM $this->table_name WHERE 1";
    //     // Add to the query
    //     // the name if it's set and not empty
    //     if ($venue_name != null || $venue_name != "") {
    //         $sql .= " AND venue_name LIKE CONCAT('%', $venue_name, '%')";
    //     }
    //     // Instead of using fetchAll(), we use our new more specific method paginate()
    //     // $venues = $this->fetchAll($sql, $query_args);
    //     $venues = $this->paginate($sql, $venue_name);
    //     return $venues;
    // }

    /**
     * Method to insert a new venue into the database.
     * @param $new_venue : new venue to be added to the database.
     * @return string|false returns the last inserted id or false.
     */
    public function insertVenue(array $new_venue): mixed
    {
        $this->insert($this->table_name, $new_venue);
        return $this->lastInsertId();
    }

    /**
     * updates one or more records contained in the specified table.
     *
     * @param  string $table table name
     * @param  array $data  an array containing the names of the field(s) to be updated along with the new value(s).
     *                      For example, ["username"=>"frostybee", "email" =>"frostybee@me.com"]
     * @param  array $where an array containing the filtering operations (it should consist of column names and values)
     *                      For example, ["user_id"=> 3]
     */
    public function updateVenue($data, $where) : void {
        $this->update($this->table_name, $data, $where);
    }
    public function deleteVenue($data) : void {
        $this->delete($this->table_name, $data);
    }

}
