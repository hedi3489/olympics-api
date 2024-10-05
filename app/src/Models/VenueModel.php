<?php

namespace App\Models;

use App\Core\PDOService;

class VenueModel extends BaseModel
{
    private string $table_name = "venues";

    public function __construct(PDOService $pdo)
    {
        parent:: __construct($pdo);
    }

    public function getVenues(array $req_params): array
    {
        $venues = [];
        $query_args = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1";

        if (isset($req_params["venues_name"])) {
            $sql .= "  AND given_name LIKE
            CONCAT('%', :venues_name, '%') ";
            $query_args['venues_name'] = $req_params["venues_name"];
        }
        $sql .= "  LIMIT 500";
        $venues = (array) $this->fetchAll($sql, $query_args);

        return $venues;
    }

    public function getVenueById(string $venue_id): mixed
    {
        //SELECT * FROM $this->table_name WHERE venue_id = $venue_id

        $sql = "SELECT * FROM venues WHERE venue_id = 1";
        $venue_info = $this->fetchSingle(
            $sql,
            ["venue_id" => $venue_id]
        );
        return $venue_info;
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

}
