<?php

namespace App\Models;

use App\Core\PDOService;
use PDO;

class ResultModel extends BaseModel
{

    private string $table_name = 'results';

    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }


    public function getResults(array $req_params): array
    {
        $sql = "SELECT * FROM `results` LIMIT 500";
        $results = $this->fetchAll($sql);
        return (array) $results;
    }

    /**
     * Inserts a new result into the database.
     * @param array $new_result
     * @return mixed The last inserted id.
     */
    public function insertResult(array $new_result): array
    {
        $sql = 'INSERT INTO `results` (`athlete_id`, `event_id`, `ranking`, `result`, `record_set`, `category`, `date`) VALUES (:athlete_id, :event_id, :ranking, :result, :record_set, :category, :date)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($new_result);
        return $stmt->errorInfo();
    }

    /**
     * Updates one or more result records
     * @param  array $data  an array containing the names of the field(s) to be updated along with the new value(s).
     *                      For example, ["username"=>"frostybee", "email" =>"frostybee@me.com"]
     * @param  array $where an array containing the filtering operations (it should consist of column names and values)
     *                      For example, ["user_id"=> 3]
     */
    public function updateResult($data, $where) : void {
        $this->update($this->table_name, $data, $where);
    }
}