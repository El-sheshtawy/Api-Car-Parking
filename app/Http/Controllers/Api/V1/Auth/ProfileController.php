<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\UpdateProfileAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json($request->user()->only('name', 'email'));
    }

    public function update(UpdateUserProfileRequest $request, UpdateProfileAction $updateProfileAction)
    {
        abort_if(auth()->guest(), Response::HTTP_UNAUTHORIZED);

        $profileData = $request->validated();

        $updateProfileAction->excute($profileData, $request->user());

        return response()->json($profileData, Response::HTTP_ACCEPTED);
    }
}
