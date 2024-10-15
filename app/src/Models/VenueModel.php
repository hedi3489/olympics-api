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

        //* Filtering by name
        if (isset($req_params["venue_name"])) {
            // Name validation
            if (ValidationHelper::isNameValid($request, $req_params["venue_name"], "venue")) {
                $sql .= "  AND venue_name LIKE
                CONCAT('%', :venue_name, '%') ";
                $query_args['venue_name'] = $req_params["venue_name"];
            }
        }

        //* Filtering by Capacity Range
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

        //* Filtering by Construction Date Range
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

        $venues = (array) $this->paginate($sql, $query_args);
        return $venues;
    }


    /**
     * Checks whether a venue name format is valid.
     * @param string $req_params an array containing the name to be validated.
     * @return bool
     */
    private function isVenueNameValid($request, $venue_name): bool
    {
        // Check if the venue name is provided
        if (empty($venue_name)) {
            throw new HttpException(
                $request,
                "No venue name was provided.",
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }
        // Validate the format: Only letters and spaces are allowed
        if (!ValidationHelper::isAlpha($venue_name)) {
            throw new HttpBadRequestException(
                $request,
                "Invalid venue name. Only letters and spaces are allowed."
            );
        }

        return true; // Venue name is valid and exists in the database
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

    public function getVenuesByName(string $venue_name): array
    {
        $venues = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1";
        //! Add to the query
        //! the name if it's set and not empty
        if ($venue_name != null || $venue_name != "") {
            $sql .= " AND venue_name LIKE CONCAT('%', $venue_name, '%')";
        }
        // Instead of using fetchAll(), we use our new more specific method paginate()
        // $venues = $this->fetchAll($sql, $query_args);
        $venues = $this->paginate($sql, $venue_name);
        return $venues;
    }

    public function insertVenue(array $new_venue): mixed
    {
        //?
        $this->insert($this->table_name, $new_venue);
        return $new_venue["venue_id"];
    }
}
