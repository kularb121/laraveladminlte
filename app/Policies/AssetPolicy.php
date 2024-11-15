<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Asset;

class AssetPolicy
{
    public function create(User $user)
    {
        return $user->hasRole('Administrator') || $user->hasRole('Manager'); 
    }

    public function edit(User $user, Asset $asset)
    {
        return $user->hasRole('Administrator') || $user->hasRole('Manager');
    }

    public function delete(User $user, Asset $asset)
    {
        return $user->hasRole('Administrator') || $user->hasRole('Manager');
    }
}
