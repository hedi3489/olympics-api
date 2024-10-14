<?php

namespace App\Models;

use App\Core\PDOService;

class CountryModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Get all country records
     * @return array 
     */
    public function getCountries(): array
    {
        $sql = "SELECT * FROM `countries` LIMIT 500";
        $countries = $this->fetchAll($sql);
        return (array) $countries;
    }
}