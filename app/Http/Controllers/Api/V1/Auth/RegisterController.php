<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, RegisterService $registerService)
    {
       $userData = $request->validated();

        try {
            DB::beginTransaction();
            $user        = $registerService->createUser($userData);
            $accessToken = $registerService->createAccessToken($user, $request->userAgent());
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            abort(422, $ex->getMessage());
        }

        event(new Registered($user));

        return response()->json([
            'user' => $user ,
            'access_token' => $accessToken,
        ], Response::HTTP_CREATED);
    }
}
