<?php

namespace App\Models;

use App\Core\PDOService;
use App\Exceptions\HttpBadFilterException;
use App\Validation\ValidationHelper;
use Psr\Http\Message\ServerRequestInterface as Request;

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
    public function getAthletes(array $req_params, Request $request): array
    {
        $athletes = [];
        $query_args = [];
        $sql = "SELECT * FROM $this->table_name WHERE 1";

        //* Filtering by country_id
        if (isset($req_params["country_id"])) {
            //* We want to throw a custom bad filter extension if not numeric
            if (ValidationHelper::isInt($req_params["country_id"])) {
                $sql .= " AND country_id = :country_id";
                $query_args["country_id"] = $req_params["country_id"];
            } else {
                throw new HttpBadFilterException($request);
            }
        }

        //* Filtering by gender
        if (isset($req_params["gender"])) {
            //* We want to throw a custom bad filter extension if not alphabetic
            if (ValidationHelper::isAlpha($req_params["gender"])) {
                $sql .= " AND gender = :gender";
                $query_args["gender"] = $req_params["gender"];
            } else {
                throw new HttpBadFilterException($request);
            }
        }

        //* Filtering by ethnicity
        if (isset($req_params["ethnicity"])) {
            //* We want to throw a custom bad filter extension if not alphabetic
            if (ValidationHelper::isAlpha($req_params["ethnicity"])) {
                $sql .= " AND ethnicity = :ethnicity";
                $query_args["ethnicity"] = $req_params["ethnicity"];
            } else {
                throw new HttpBadFilterException($request);
            }
        }

        //* Sorting - valid fields: athlete_name | date_of_birth | others as well...
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

    /**
     * Inserts a new athlete into the database.
     * @param array $new_athlete | The athlete object to create.
     * @return mixed The last inserted id.
     */
    public function insertAthlete(array $new_athlete): mixed
    {
        $this->insert($this->table_name, $new_athlete);
        return $this->lastInsertId();
    }
}
