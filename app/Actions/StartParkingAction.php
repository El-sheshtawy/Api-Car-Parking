<?php

namespace App\Actions;

use App\Models\Parking;

class StartParkingAction
{
    public function start($parkingData)
    {
        if (Parking::active()
            ->where('vehicle_id', $parkingData['vehicle_id'])
            ->exists()) {
          throw new \Exception('Can\'t start parking twice using same vehicle. Please stop currently active parking.');
        }

        $parking = Parking::create($parkingData);
        $parking->load('vehicle', 'zone');
        return $parking;
    }
}
