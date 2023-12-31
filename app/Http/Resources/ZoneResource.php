<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZoneResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'ID'             => $this->id,
            'Zone name'           => $this->name,
            'Price per hour' => $this->price_per_hour,
        ];
    }
}
