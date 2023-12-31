<?php

namespace App\Actions;

use App\Models\Zone;
use App\Traits\UploadImageTrait;

class StoreZoneAction
{
    use UploadImageTrait;

    public function excute(array $zoneData)
    {
        $image = $this->uploadImage('image', 'zones');

        $zoneData['image'] = $image;

       return Zone::create($zoneData);
    }
}
