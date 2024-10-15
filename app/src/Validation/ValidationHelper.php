<?php

declare(strict_types=1);

namespace App\Validation;

use Fig\Http\Message\StatusCodeInterface;
use Slim\Exception\HttpException;
use Slim\Exception\HttpBadRequestException;

/**
 * A helper class that exposes various data validation functions.
 * @author frostybee
 */
class ValidationHelper
{


    /**
     * Checks whether a string contains only alphabetic characters.
     * @param mixed $value the string to be validated
     * @return mixed false if the value is invalid. Otherwise, the sanitized string will be returned.
     */
    public static function isAlpha($value): mixed
    {
        $value = filter_var(trim($value), FILTER_SANITIZE_ADD_SLASHES);
        if (ctype_alpha($value)) {
            return $value;
        }
        return false;
    }

    /**
     * Checks whether a value is an integer and is within a range.
     * @param mixed $value an input value to be validated
     * @param int $min the lower bound of the range of allowed values
     * @param int $max the upper bound of the range of allowed values
     * @return bool|array
     */
    public static function isIntAndInRange($value, int $min, int $max): mixed
    {
        return filter_var($value, FILTER_VALIDATE_INT, static::getRangeOptions($min, $max));
    }


    /**
     * Checks whether a value is a valid integer and is greater than
     * the specified min value.
     * @param mixed $input an input value to be validated
     * @return mixed bool|array
     */
    public static function isInt($input, int $min = -1): mixed
    {
        if ($min >= 0) {
            return filter_var($input, FILTER_VALIDATE_INT, self::getMinRangeOptions($min));
        }

        return filter_var($input, FILTER_VALIDATE_INT);
    }
    public static function getMinRangeOptions(int $min): array
    {
        return array("options" => array("min_range" => $min));
    }
    public static function getRangeOptions(int $min, int $max): array
    {
        return array(
            "options" =>
            array("min_range" => $min, "max_range" => $max)
        );
    }

    /**
     * Determines whether an array is associative or not.
     *
     * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
     * Note that an array in PHP can be either sequential or associative.
     *
     * @param  array  $array the array to be verified.
     * @return bool
     */
    public static function isAssoc(array $input): bool
    {
        if (empty($input)) {
            return false;
        }
        $keys = array_keys($input);
        return array_keys($keys) !== $keys;
    }


    /**
     * Checks whether a date value format is valid.
     * @param string $date a string of the date provided on the client side.
     * @param int $minOrMax a string value representing weather the date is min or max
     * @return bool
     */
    public static function isDateRangeValid($request, String $date, String $minOrMax): bool
    {
        // Check if date value has been provided
        if ($date == NULL) {
            throw new HttpBadRequestException(
                $request,
                "No {$minOrMax}_date_constructed was provided."
            );
        }
        // Validate date format
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
            throw new HttpBadRequestException(
                $request,
                "Invalid {$minOrMax}_date_constructed. Format must be 'YYYY-MM-DD.'"
            );
        }
        return true; // Date range filtering is valid
    }


    /**
     * Checks whether a min value is smaller than max value.
     * @param int $min the min provided values by the client side
     * @param int $max the max provided values by the client side
     * @param string $type the datatype of the value (int/date)
     * @param string $param_name the parameter name that will be used in error handling
     * @return void
     */
    public static function minMaxValidation($request, $min, $max, $type, $param_name)
    {
        switch ($type) {
            case "int":
                if (!ValidationHelper::isIntAndInRange($max, 0, 100000)) {
                    throw new HttpBadRequestException(
                        $request,
                        "Max_capacity range value must be a number between 0 and 100000."
                    );
                }
                if ($min >= $max) {
                    throw new HttpBadRequestException(
                        $request,
                        "Minimum {$param_name} cannot be greater than maximum {$param_name}. "
                    );
                }
                break;
            case "date":
                if (ValidationHelper::isDateRangeValid($request, (string)$max, "max")) {
                    $min_date = new \DateTime((string)$min);
                    $max_date = new \DateTime((string)$max);
                    if ($min_date >= $max_date) {
                        throw new HttpBadRequestException(
                            $request,
                            "Minimum {$param_name} cannot be greater than maximum {$param_name}."
                        );
                    }
                }
                break;
        }
    }


    /**
     * Checks whether a resource name is valid: including only letters and spaces.
     * @param $request in order to throw and HttpException when needed.
     * @param string $name the string value to be evaluated.
     * @param string $resource the name of the resource to use when handling exceptions: venue/event/...
     * @return bool
     */
    public static function isNameValid($request, $name, $resource): bool
    {
        // Check if the venue name is provided
        if (empty($name)) {
            throw new HttpException(
                $request,
                "No {$resource} name was provided.",
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }
        // Validate the format: Only letters and spaces are allowed
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            throw new HttpBadRequestException(
                $request,
                "Invalid {$resource} name. Only letters and spaces are allowed."
            );
        }

        return true;
    }
}
