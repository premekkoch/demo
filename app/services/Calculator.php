<?php declare(strict_types=1);

namespace App\Services;

final class Calculator
{
    /**
     * @param int $count
     * @param int $total
     * @return float
     */
    public function calculateRatio(int $count, int $total): float
    {
        if ($total === 0) {
            return 0;
        }

        return $count / $total * 100;
    }
}
