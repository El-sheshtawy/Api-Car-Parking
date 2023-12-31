<?php

namespace App\Actions;

use Illuminate\Contracts\Auth\Authenticatable;

class LogoutAction
{
    public function destroyAccessToken(Authenticatable $user)
    {
        return $user->currentAccessToken()->delete();
    }
}
