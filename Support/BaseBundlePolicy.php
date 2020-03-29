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
        return $user->hasPermissionTo('manage fields');
    }

    public function editFields(?User $user, BundleContract $bundle)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('manage fields');
    }

    public function deleteFields(?User $user, BundleContract $bundle)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('manage fields');
    }

    public function createFields(?User $user, BundleContract $bundle)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('manage fields');
    }

    public function fieldLayout(?User $user, BundleContract $bundle)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('manage layout');
    }

    public function fieldDisplay(?User $user, BundleContract $bundle)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('manage display');
    }
}