<?php

namespace App\Actions;

use App\Models\User;

class UpdateProfileAction
{
    public function excute(array $profileData, User $user)
    {
       return $user->update($profileData);
    }
}
