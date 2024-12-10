<?php

namespace App\Services;

use App\Core\Result;

/**
 * Katch-McArdle Formula:
 *   BMR = 370 + 21.6(1 - F)W
 *
 *   where:
 *   W is body weight in kg
 *   F is body fat in percentage
 */
class BMRService extends BaseService
{
    public function CalculateBMR($request, $data): Result
    {
        //* Validate through Valitron
        // Calling custom function for dynamic Valitron validation
        $this->executeValitron($request, $data);

        // If data is valid, compute basal metabolic rate
        try {
            $bmr = $this->computeBMR($data['weight'], $data['body_fat']);
            // Return success Result with computed bmr
            return Result::success("Your basal metabolic rate is: $bmr. That means your body burns around that many calories a day by default!");
        } catch (\PDOException $e) {
            // Handle any database errors and return a fail Result
            return Result::fail("Error: Unable to compute bmr.");
        }
    }

    private function computeBMR($weight, $body_fat): float
    {
        return 370 + 21.6 * (1 - $body_fat) * $weight;
    }

    private function executeValitron($request, array $data): void
    {
        $v = new \Valitron\Validator($data);

        $v->rule('required', ['weight', 'body_fat']);
        $this->runValitron($request, $v);

        $v->rule('integer', 'weight')->message('Weight must be an integer in Kg.');
        $v->rule('numeric', 'body_fat')->message('Body fat must be a number such as: (0.15)');

        $v->rule('min', 'weight', 2)->message('Weight must be between 2-700 Kg.');
        $v->rule('max', 'weight', 700)->message('Weight must be between 2-700 Kg.');

        $v->rule('min', 'body_fat', 0.02)->message('Body fat must be more than 0.02');
        $v->rule('max', 'body_fat', 0.5)->message('Body fat must be less than 0.5');
        $this->runValitron($request, $v);
    }
}
