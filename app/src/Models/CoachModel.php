<?php

namespace App\Models;

use App\Core\PDOService;
use App\Exceptions\HttpBadFilterException;
use App\Validation\ValidationHelper;
use Psr\Http\Message\ServerRequestInterface as Request;

class CoachModel extends BaseModel
{
    private string $table_name = "coaches";

    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Gets all coaches in the database.
     * @param array $req_params - The parameters from the request.
     * @return array - The resulting array of coaches.
     */
    public function getCoaches(array $req_params, Request $request): array
    {
        $coaches = [];
        $query_args = [];
        $sql = "SELECT * FROM coaches WHERE 1";

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

        //* Filtering by sport
        if (isset($req_params["sport"])) {
            //* We want to throw a custom bad filter extension if not alphabetic or space
            if (ValidationHelper::isNameValid($request, $req_params["sport"], "coach sport")) {
                $sql .= " AND sport = :sport";
                $query_args["sport"] = $req_params["sport"];
            } else {
                throw new HttpBadFilterException($request);
            }
            $sql .= " AND sport = :sport";
            $query_args["sport"] = $req_params["sport"];
        }

        //* Filter by been_in_olympics
        if (isset($req_params["been_in_olympics"])) {
            //* We want to throw a custom bad filter extension if not 0 or 1
            //TODO This currently breaks if 0
            if (ValidationHelper::isIntAndInRange($req_params["been_in_olympics"], 0, 1)) {
                $sql .= " AND been_in_olympics = :been_in_olympics";
                $query_args["been_in_olympics"] = $req_params["been_in_olympics"];
            } else {
                throw new HttpBadFilterException($request);
            }
        }

        //* Sorting - valid fields: coach_name | date_of_birth
        $sort_by = $req_params["sort_by"] ?? "coach_name";
        $order_by = $req_params["order_by"] ?? "asc";

        // Append sorting to the query
        $sql .= " ORDER BY $sort_by $order_by";

        $coaches = (array) $this->paginate($sql, $query_args);
        return $coaches;
    }

    /**
     * Get a single coach record by their id in the database.
     * @param int $coach_id - Id of the coach requested.
     * @return mixed - The resulting populated coach record.
     */
    public function getCoachById(int $coach_id): mixed
    {
        $sql = "SELECT * FROM $this->table_name WHERE coach_id = :coach_id";
        $coach = $this->fetchSingle(
            $sql,
            ["coach_id" => $coach_id]
        );
        return $coach;
    }

    /**
     * Inserts a new coach into the database.
     * @param array $new_coach | The coach object to create.
     * @return mixed The last inserted id.
     */
    public function insertCoach(array $new_coach): mixed
    {
        return $this->insert($this->table_name, $new_coach);
    }

    /**
     * Updates an existing coach in the database.
     * @param array $coach_data | The coach data to update.
     * @param array $where | Array containing the coach objects' id to update.
     * @return mixed The row count, but functionally ends up being the updated data.
     */
    public function updateCoach(array $coach_data, $where): mixed
    {
        return $this->update($this->table_name, $coach_data, $where);
    }
}
