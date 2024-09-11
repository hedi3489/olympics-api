<?php

namespace App\Models;

use App\Core\PDOService;

class AthleteModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    public function getAthletes(array $req_params): array
    {
        $athletes = [];
        $query_args = [];
        $sql = "SELECT * FROM athlete WHERE 1";

        if (isset($req_params["athlete_name"])) {
            $sql .= "  AND given_name LIKE
            CONCAT('%', :athlete_name, '%') ";
            $query_args['athlete_name'] = $req_params["athlete_name"];
        }
        $sql .= "  LIMIT 500";
        $athletes = (array) $this->fetchAll($sql, $query_args);

        return $athletes;
    }
}
