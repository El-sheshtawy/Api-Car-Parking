<?php

namespace App\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class UpdateProfilePasswordAction
{
    public function update(Authenticatable $user, $password)
    {
       return $user->update([
            'password' => Hash::make($password),
        ]);
    }
}
