<?php

namespace App\Http\Controllers\Api\V2;

use App\Actions\StoreZoneAction;
use App\Actions\UpdateZoneAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use App\Http\Resources\ZoneResource;
use App\Models\Zone;
use Illuminate\Http\Response;

/**
 * @group Zones
 *
 * Managing Zones
 */
class ZoneController extends Controller
{
    /**
     *  Get Zones
     *
     *  List all the zones
     *
     * @queryParam page which page to show. Example: 12
     */
    public function index()
    {
//        if (! auth()->user()->tokenCan('zones-list')) {
//            abort(403, 'Unauthorized');
//        }
        return ZoneResource::collection(Zone::select(['id', 'name', 'price_per_hour'])->get());
    }

    /**
     *  Post Zones
     *
     *  Create new zone
     *
     * @bodyParam name string required Name of Zone. Example: "Mostafa Kamel Street" and so on.
     */
    public function store(StoreZoneRequest $storeZoneRequest, StoreZoneAction $storeZoneAction)
    {
        if (! auth()->user()->tokenCan('zone-create')) {
            abort(403, 'Unauthorized');
        }

        $zoneData = $storeZoneRequest->validated();

        $zone = $storeZoneAction->excute($zoneData);

        return response()->json([
            'Created data' => ZoneResource::make($zone),
            'Success message' => 'New zone has been created',
        ], Response::HTTP_CREATED);
    }

    /**
     *  Show Zone
     *
     *  show a zone
     */
    public function show(Zone $zone)
    {
        if (! auth()->user()->tokenCan('zone-show')) {
            abort(403, 'Unauthorized');
        }

        return ZoneResource::make($zone);
    }

    /**
     *  Update Zone
     *
     *  update a zone
     */
    public function update(UpdateZoneRequest $updateZoneRequest, UpdateZoneAction $updateZoneAction, Zone $zone)
    {
        if (! auth()->user()->tokenCan('zone-update')) {
            abort(403, 'Unauthorized');
        }

        $zoneData = $updateZoneRequest->validated();

        $updateZoneAction->excute($zone, $zoneData);

        return response()->json([
            'Updated data' => ZoneResource::make($zone),
            'Success message' => 'The zone has been updated successfully',
        ], Response::HTTP_ACCEPTED);
    }

    /**
     *  Delete Zone
     *
     *  delete a zone
     */
    public function destroy(Zone $zone)
    {
        if (! auth()->user()->tokenCan('zone-delete')) {
            abort(403, 'Unauthorized');
        }

        $zone->delete();

        return response()->noContent();
    }
}
