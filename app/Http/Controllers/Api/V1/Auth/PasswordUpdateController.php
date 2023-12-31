<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\UpdateProfilePasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserProfilePasswordRequest;
use Illuminate\Http\Response;

class PasswordUpdateController extends Controller
{
    public function __invoke(UpdateUserProfilePasswordRequest $request, UpdateProfilePasswordAction $updateProfilePasswordAction)
    {
       $profileData = $request->validated();

        $updateProfilePasswordAction->update(auth()->user(), $profileData['password']);

        return response()->json([
            'message' => 'The password has been updated.',
        ], Response::HTTP_ACCEPTED);
    }
}
