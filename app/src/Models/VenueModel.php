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

    public function getVenues($request, array $req_params): array
    {
        $venues = [];
        $query_args = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1";

        //* Filtering by name
        if (isset($req_params["venue_name"])) {
            // Name validation
            if ($this->isVenueNameValid($request, $req_params["venue_name"])) {
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
                $this->minMaxValidation($request, $req_params["min_capacity"], $req_params["min_capacity"], "int", "capacity");
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
            if ($this->isDateRangeValid($request, (string) $req_params["min_date_constructed"], "min")) {
                if (isset($req_params["max_date_constructed"])) {
                    $this->minMaxValidation($request, $req_params["min_date_constructed"], $req_params["max_date_constructed"], "date", "date_constructed");
                }
                $sql .= " AND date_constructed >= :min_date_constructed";
                $query_args['min_date_constructed'] = $req_params["min_date_constructed"];
            }
        }
        if (isset($req_params["max_date_constructed"])) {
            if ($this->isDateRangeValid($request, (string) $req_params["max_date_constructed"], "max")) {
                $sql .= " AND date_constructed <= :max_date_constructed";
                $query_args['max_date_constructed'] = $req_params["max_date_constructed"];
            }
        }

        //$sql .= "  LIMIT 500";
        //$venues = (array) $this->fetchAll($sql, $query_args);
        $venues = (array) $this->paginate($sql, $query_args);
        return $venues;
    }


    /**
     * Checks whether a venue name format is valid.
     * @param string $req_params an array containing the name to be validated.
     * @return bool
     */
    private function isVenueNameValid($request, $req_param): bool
    {
        // Check if the venue name is provided
        if (!isset($req_param) || empty($req_param)) {
            throw new HttpException(
                $request,
                "No venue name was provided.",
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }
        // Validate the format: Only letters and spaces are allowed
        $venue_name = $req_param;
        if (!ValidationHelper::isAlpha($venue_name)) {
            throw new HttpBadRequestException(
                $request,
                "Invalid venue name. Only letters and spaces are allowed."
            );
        }

        //echo "leaving validation";
        return true; // Venue name is valid and exists in the database
    }

    /**
     * Checks whether a date value format is valid.
     * @param string $date a string of the date provided on the client side.
     * @param int $minOrMax a string value representing weather the date is min or max
     * @return bool
     */
    private function isDateRangeValid($request, String $date, String $minOrMax): bool
    {
        // Check if date value has been provided
        if ($date == NULL) {
            throw new HttpBadRequestException(
                $request,
                "No {$minOrMax}_date_constructed was provided."
            );
        }
        // Validate date format
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
            throw new HttpBadRequestException(
                $request,
                "Invalid {$minOrMax}_date_constructed. Format must be 'YYYY-MM-DD.'"
            );
        }
        return true; // Date range filtering is valid
    }


    /**
     * Checks whether a min value is smaller than max value.
     * @param int $min the min provided values by the client side
     * @param int $max the max provided values by the client side
     * @param string $type the datatype of the value (int/date)
     * @param string $param_name the parameter name that will be used in error handling
     * @return void
     */
    private function minMaxValidation($request, $min, $max, $type, $param_name)
    {
        switch ($type) {
            case "int":
                if (!ValidationHelper::isIntAndInRange($max, 0, 100000)) {
                    throw new HttpBadRequestException(
                        $request,
                        "Max_capacity range value must be a number between 0 and 100000."
                    );
                }
                if ($min >= $max) {
                    throw new HttpBadRequestException(
                        $request,
                        "Minimum {$param_name} cannot be greater than maximum {$param_name}. "
                    );
                }
                break;
            case "date":
                if ($this->isDateRangeValid($request, $max, "max")) {
                    $min_date = new \DateTime($min);
                    $max_date = new \DateTime($max);
                    if ($min_date >= $max_date) {
                        throw new HttpBadRequestException(
                            $request,
                            "Minimum {$param_name} cannot be greater than maximum {$param_name}."
                        );
                    }
                }
                break;
        }
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
