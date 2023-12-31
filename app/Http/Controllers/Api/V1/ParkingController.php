<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\StartParkingAction;
use App\Actions\StopParkingAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StartParkingRequest;
use App\Http\Resources\ParkingResource;
use App\Models\Parking;
use Illuminate\Http\Response;

class ParkingController extends Controller
{
    public function start(StartParkingRequest $request, StartParkingAction $startParkingAction)
    {
        $parkingData = $request->validated();

        try {
          $parking = $startParkingAction->start($parkingData);
        } catch (\Exception $ex) {
            return response()->json([
                'errors' => ['general' => $ex->getMessage()],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parking->load('vehicle', 'zone');

        return ParkingResource::make($parking);
    }

    public function show(Parking $parking)
    {
        return ParkingResource::make($parking);
    }

    public function stop(Parking $parking, StopParkingAction $stopParkingAction)
    {
        try {
            $stopParkingAction->stop($parking);
        } catch (\Exception $ex) {
            return response()->json([
                'error' => $ex->getMessage() ,
            ], Response::HTTP_BAD_REQUEST);
        }

        return ParkingResource::make($parking);
    }
}
