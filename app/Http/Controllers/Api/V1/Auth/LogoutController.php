<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\LogoutAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    public function __invoke(Request $request, LogoutAction $logoutAction)
    {
        $logoutAction->destroyAccessToken(auth()->user());

        return response()->json([
            'message' => 'The user has been logged out',
        ], Response::HTTP_ACCEPTED);

        // or return response()->noContent();
    }
}
