<?php

namespace App\Models;

use App\Core\PDOService;

class AthleteModel extends BaseModel
{
    private string $table_name = "athletes";

    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Gets all athletes in the database.
     * @param array $req_params - The parameters from the request.
     * @return array - The resulting array of athletes.
     */
    public function getAthletes(array $req_params): array
    {
        $athletes = [];
        $query_args = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1";

        //* Filtering by country_id
        if (isset($req_params["country_id"])) {
            $sql .= " AND country_id = :country_id";
            $query_args["country_id"] = $req_params["country_id"];
        }

        //* Filtering by gender
        if (isset($req_params["gender"])) {
            $sql .= " AND gender = :gender";
            $query_args["gender"] = $req_params["gender"];
        }

        //* Filtering by ethnicity
        if (isset($req_params["ethnicity"])) {
            $sql .= " AND ethnicity = :ethnicity";
            $query_args["ethnicity"] = $req_params["ethnicity"];
        }

        //* Sorting - valid fields: athlete_name | date_of_birth
        $sort_by = $req_params["sort_by"] ?? "athlete_name";
        $order_by = $req_params["order_by"] ?? "asc";

        //* Append sorting to the query
        $sql .= " ORDER BY $sort_by $order_by";

        $athletes = (array) $this->paginate($sql, $query_args);
        return $athletes;
    }

    /**
     * Get a single athlete record by their id in the database.
     * @param int $athlete_id - Id of the athlete requested.
     * @return mixed - The resulting populated athlete record.
     */
    public function getAthleteById(int $athlete_id): mixed
    {
        $sql = "SELECT * FROM $this->table_name WHERE athlete_id = :athlete_id";
        $athlete = $this->fetchSingle(
            $sql,
            ["athlete_id" => $athlete_id]
        );
        return $athlete;
    }
}
