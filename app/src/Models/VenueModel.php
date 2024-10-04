<?php

namespace App\Models;

use App\Core\PDOService;

class VenueModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent:: __construct($pdo);
    }

    public function getVenues(array $req_params): array
    {
        $venues = [];
        $query_args = [];
        $sql = "SELECT * FROM venues WHERE 1";

        if (isset($req_params["venues_name"])) {
            $sql .= "  AND given_name LIKE
            CONCAT('%', :venues_name, '%') ";
            $query_args['venues_name'] = $req_params["venues_name"];
        }
        $sql .= "  LIMIT 500";
        $venues = (array) $this->fetchAll($sql, $query_args);

        return $venues;
    }
}
