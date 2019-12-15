<?php

namespace Pingu\Entity\Support;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\User\Entities\User;

class BaseBundlePolicy
{
    protected function userOrGuest(?User $user)
    {
        return $user ? $user : \Permissions::guestRole();
    }

    public function indexFields(?User $user, BundleContract $bundle)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('manages bundles');
    }

    public function editFields(?User $user, BundleContract $bundle)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('manages bundles');
    }

    public function deleteFields(?User $user, BundleContract $bundle)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('manages bundles');
    }

    public function createFields(?User $user, BundleContract $bundle)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('manages bundles');
    }

    public function createGroups(?User $user, BundleContract $bundle)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('manages bundles');
    }
}