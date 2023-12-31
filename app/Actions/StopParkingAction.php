<?php

namespace App\Actions;

use App\Models\Parking;
use App\Services\ParkingPriceService;

class StopParkingAction
{
    public function stop(Parking $parking)
    {
        if ($parking->stop_time) {
            throw new \Exception('This Car already stop parking at '.$parking->stop_time);
        }
        $parking->update([
            'stop_time' => now(),
            'total_price' => ParkingPriceService::calculatePrice($parking->zone_id, $parking->start_time),
        ]);
    }
}
