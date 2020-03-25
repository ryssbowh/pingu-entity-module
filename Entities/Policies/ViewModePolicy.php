<?php 

namespace Pingu\Entity\Entities\Policies;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\Entity;
use Pingu\Entity\Support\BaseEntityPolicy;
use Pingu\User\Entities\User;

class ViewModePolicy extends BaseEntityPolicy
{
    public function index(?User $user)
    {
        return $this->userOrGuest()->hasPermissionTo('manage display');
    }

    public function delete(?User $user, Entity $entity)
    {
        return $this->userOrGuest()->hasPermissionTo('manage display');
    }

    public function create(?User $user, ?BundleContract $bundle = null)
    {
        return $this->userOrGuest()->hasPermissionTo('manage display');
    }
}