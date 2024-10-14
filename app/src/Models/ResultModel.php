<?php

namespace App\Models;

use App\Core\PDOService;

class ResultModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Get all result records
     * @return array 
     */
    public function getResults(): array
    {
        $sql = "SELECT * FROM `results` LIMIT 500";
        $results = $this->fetchAll($sql);
        return (array) $results;
    }
}