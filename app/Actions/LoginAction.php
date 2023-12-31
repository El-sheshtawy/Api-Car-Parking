<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function getAccessToken($email, $password, $userAgent, $remember = null)
    {
        $user = User::where('email', $email)->first();
        if (! $user || ! Hash::check($password, $user->password)) {
            throw new \Exception('The credentials are wrong.');
        }

        $device    = substr($userAgent ?? '', 0, 255);
        $expiresAt = $remember ? null : now()->addMinutes(config('session.lifetime'));
        return $user->createToken($device, expiresAt: $expiresAt)->plainTextToken;
    }
}
