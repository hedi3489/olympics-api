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

        //* Filter by athlete_name
        if (isset($req_params["athlete_name"])) {
            $sql .= "  AND given_name LIKE
            CONCAT('%', :athlete_name, '%') ";
            $query_args['athlete_name'] = $req_params["athlete_name"];
        }
        $athletes = (array) $this->fetchAll($sql, $query_args);

        return $athletes;
    }

    /**
     * Get method for path parameter athlete_id. Fetches a single row based on provided id.
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
