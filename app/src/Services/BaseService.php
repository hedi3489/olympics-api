<?php

namespace App\Services;

use Slim\Exception\HttpBadRequestException;

class BaseService
{
    /**
     * Function to validate the defined rules.
     * This function was made because of a Valitron problem:
     * ----- 'Required' doesn't interrupt the validation process when a required field
     * ----- is missing unless validate() is run immediately after.
     * @param mixed $request : used for throwing an exception.
     * @param mixed $v : Valitron object.
     * @throws \Slim\Exception\HttpBadRequestException
     * @return void
     */
    protected static function runValitron($request, $v) : void
    {
        // dd($v);
        if(!$v->validate()){
            $errors = json_encode($v->errors());
            // dd($errors);
            throw new HttpBadRequestException(
                $request,
                "Invalid data: $errors"
            );
        }
    }
}
