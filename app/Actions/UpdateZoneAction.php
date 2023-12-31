<?php

namespace App\Actions;

use App\Models\Zone;

class UpdateZoneAction
{
    public function excute(Zone $zone, array $zoneData)
    {
        return $zone->update($zoneData);
    }
}
