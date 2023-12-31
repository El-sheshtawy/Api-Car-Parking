<?php

namespace App\Http\Resources;

use App\Services\ParkingPriceService;
use Illuminate\Http\Resources\Json\JsonResource;

class ParkingResource extends JsonResource
{
    public function toArray($request): array
    {
        $totalPrice = $this->total_price ?? ParkingPriceService::calculatePrice(
            $this->zone_id,
            $this->start_time,
            $this->stop_time
        );

        return [
            'id' => $this->id,
            'zone' => [
                'Zone details' => ZoneResource::make($this->zone),
            ],
            'vehicle' => [
                'plate_number' => $this->vehicle->plate_number
            ],
            'start_time' => $this->start_time->toDateTimeString(),
            'stop_time' => $this->stop_time?->toDateTimeString(),
            'total_price' => $totalPrice,
        ];
    }
}
