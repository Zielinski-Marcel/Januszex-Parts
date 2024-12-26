<?php

namespace App\Services\SpendingServices;
use App\Models\User;
use App\Models\Spending;
use DateTime;
class CreateSpendingService{
    public function execute(
         float $price,
         DateTime $date,
         string $type,
         User $user,
         string $place,
         string $description): Spending{
        return new Spending(
            $price,
            $date,
            $type,
            $user,
            $place,
            $description
        );
    }
}
