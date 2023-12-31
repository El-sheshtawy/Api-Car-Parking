<?php

namespace App\Services;

use App\Models\User;

class RegisterService
{
    public function createUser(array $userData)
    {
        return User::create($userData);
    }

    public function createAccessToken($user, $userAgent)
    {
        $device = substr($userAgent ?? '', 0, 255);

        if (! $user) {
            throw new \Exception('You must register successfully to have access token');
        }

        return $user->createToken($device)->plainTextToken;
    }
}
