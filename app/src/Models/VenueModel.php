<?php

namespace App\Models;

use App\Core\PDOService;

class VenueModel extends BaseModel
{
    private string $table_name = "venues";

    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    public function getVenues(array $req_params): array
    {
        $venues = [];
        $query_args = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1";

        //* Filtering by name
        if (isset($req_params["venue_name"])) {
            $sql .= "  AND venue_name LIKE
            CONCAT('%', :venue_name, '%') ";
            $query_args['venue_name'] = $req_params["venue_name"];
        }

        //* Filtering by Capacity Range
        if (isset($req_params["min_capacity"])) {
            $sql .= " AND capacity >= :min_capacity";
            $query_args['min_capacity'] = $req_params["min_capacity"];
        }
        if (isset($req_params["max_capacity"])) {
            $sql .= " AND capacity <= :max_capacity";
            $query_args['max_capacity'] = $req_params["max_capacity"];
        }

        //* Filtering by Construction Date Range
        if (isset($req_params["min_date_constructed"])) {
            $sql .= " AND date_constructed >= :min_date_constructed";
            $query_args['min_date_constructed'] = $req_params["min_date_constructed"];
        }
        if (isset($req_params["max_date_constructed"])) {
            $sql .= " AND date_constructed <= :max_date_constructed";
            $query_args['max_date_constructed'] = $req_params["max_date_constructed"];
        }

        $sql .= "  LIMIT 500";
        $venues = (array) $this->fetchAll($sql, $query_args);

        return $venues;
    }

    public function getVenueById(string $venue_id): mixed
    {
        //SELECT * FROM $this->table_name WHERE venue_id = $venue_id

        //$sql = "SELECT * FROM venues WHERE venue_id = 2";
        $sql = "SELECT * FROM venues WHERE venue_id = :venue_id";
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
