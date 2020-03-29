<?php 

namespace Pingu\Entity\Entities\Policies;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\Entity;
use Pingu\Entity\Support\Policies\BaseEntityPolicy;
use Pingu\User\Entities\User;

class ViewModePolicy extends BaseEntityPolicy
{
    public function index(?User $user)
    {
        return $this->userOrGuest($user)->hasPermissionTo('manage display');
    }

    public function delete(?User $user, Entity $entity)
    {
        if ($entity->machineName == 'default') {
            return false;
        }
        return $this->userOrGuest($user)->hasPermissionTo('manage display');
    }

    public function edit(?User $user, Entity $entity)
    {
        return $this->userOrGuest($user)->hasPermissionTo('manage display');
    }

    public function create(?User $user, ?BundleContract $bundle = null)
    {
        return $this->userOrGuest($user)->hasPermissionTo('manage display');
    }
}