<?php

namespace App\Http\Controllers\Api\V2\Auth;

use App\Actions\LogoutAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Authentication
 *
 * Managing authentication
 */
class LogoutController extends Controller
{
    /**
     *  Logout
     *
     *  User logging out
     */
    public function __invoke(Request $request, LogoutAction $logoutAction)
    {
        $logoutAction->destroyAccessToken(auth()->user());

        return response()->json([
            'message' => 'The user has been logged out',
        ], Response::HTTP_ACCEPTED);

        // or return response()->noContent();
    }
}
