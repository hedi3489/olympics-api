<?php

namespace App\Models;

use App\Core\PDOService;

class CoachModel extends BaseModel
{
    public function __construct(PDOService $pdo) {
        parent::__construct($pdo);
    }

    public function getCoaches(array $req_params): array {
        $coaches = [];
        $query_args = [];
        $sql = "SELECT * FROM coaches WHERE 1";

        //* Filter by coach_name
        if (isset($req_params["coach_name"])) {
            $sql .= " AND coach_name LIKE
                CONCAT('%', :coach_name, '%')";
            $query_args["coach_name"] = $req_params["coach_name"];
        }
        $coaches = (array) $this->fetchAll($sql, $query_args);

        return $coaches;
    }
}
