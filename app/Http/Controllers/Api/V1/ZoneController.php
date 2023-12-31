<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\StoreZoneAction;
use App\Actions\UpdateZoneAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use App\Http\Resources\ZoneResource;
use App\Models\Zone;
use Illuminate\Http\Response;

class ZoneController extends Controller
{
    public function index()
    {
        return ZoneResource::collection(Zone::select(['id', 'name', 'price_per_hour'])->paginate(1));
    }

    public function store(StoreZoneRequest $storeZoneRequest, StoreZoneAction $storeZoneAction)
    {
        $zoneData = $storeZoneRequest->validated();

        $zone = $storeZoneAction->excute($zoneData);

        return response()->json([
            'Created data' => ZoneResource::make($zone),
            'Success message' => 'New zone has been created',
        ], Response::HTTP_CREATED);
    }

    public function show(Zone $zone)
    {
        return ZoneResource::make($zone);
    }

    public function update(UpdateZoneRequest $updateZoneRequest, UpdateZoneAction $updateZoneAction, Zone $zone)
    {
        $zoneData = $updateZoneRequest->validated();

        $updateZoneAction->excute($zone, $zoneData);

        return response()->json([
            'Updated data' => ZoneResource::make($zone),
            'Success message' => 'The zone has been updated successfully',
        ], Response::HTTP_ACCEPTED);
    }

    public function destroy(Zone $zone)
    {
        $zone->delete();

        return response()->noContent();
    }
}
