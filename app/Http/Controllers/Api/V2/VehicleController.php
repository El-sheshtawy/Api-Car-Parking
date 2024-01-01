<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Response;

/**
 * @group Vehicles
 *
 * Managing Vehicles
 */
class VehicleController extends Controller
{
    /**
     *  Get Vehicles
     *
     *  List all the vehicles
     */
    public function index()
    {
        return VehicleResource::collection(Vehicle::all(['id', 'plate_number']));
    }

    /**
     *  Create Vehicle
     *
     *  Create a vehicle
     */
    public function store(StoreVehicleRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());

        return VehicleResource::make($vehicle);
    }

    /**
     *  Show Vehicle
     *
     *  show a vehicle
     */
    public function show(Vehicle $vehicle)
    {
        return VehicleResource::make($vehicle);
    }

    /**
     *  Update Vehicle
     *
     *  update a vehicle
     */
    public function update(StoreVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());

        return response()->json(VehicleResource::make($vehicle), Response::HTTP_ACCEPTED);
    }

    /**
     *  Delete Vehicle
     *
     *  delete a vehicle
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return response()->noContent();
    }
}
