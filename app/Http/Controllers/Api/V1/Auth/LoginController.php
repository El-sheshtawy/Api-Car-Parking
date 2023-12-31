<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, LoginAction $loginAction)
    {
        $validatedData = $request->validated();
        try {
           $accessToken = $loginAction->getAccessToken($validatedData['email'], $validatedData['password'], $request->userAgent());
        } catch (\Exception $ex) {
            return response()->json([
                'error' => $ex->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'access_token' => $accessToken,
        ], Response::HTTP_CREATED);
    }
}
