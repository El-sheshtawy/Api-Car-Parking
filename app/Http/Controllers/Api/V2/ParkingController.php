<?php

namespace App\Http\Controllers\Api\V2;

use App\Actions\StartParkingAction;
use App\Actions\StopParkingAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StartParkingRequest;
use App\Http\Resources\ParkingResource;
use App\Models\Parking;
use Illuminate\Http\Response;

/**
 * @group Parking
 *
 * Managing parking
 */
class ParkingController extends Controller
{
    /**
     *  Start parking
     *
     *  start the parking
     */
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

    /**
     *  Show parking
     *
     *  show the parking details
     */
    public function show(Parking $parking)
    {
        return ParkingResource::make($parking);
    }

    /**
     *  Stop parking
     *
     *  stop the parking
     */
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
