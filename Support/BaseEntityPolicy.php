<?php

namespace Pingu\Entity\Support;

use Pingu\Core\Support\Policy;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\Entity;
use Pingu\User\Entities\User;

class BaseEntityPolicy extends Policy
{
    protected function userOrGuest(?User $user)
    {
        return $user ? $user : \Permissions::guestRole();
    }

    public function index(?User $user)
    {
        return false;
    }

    public function view(?User $user, Entity $entity)
    {
        return false;
    }

    public function edit(?User $user, Entity $entity)
    {
        return false;
    }

    public function delete(?User $user, Entity $entity)
    {
        return false;
    }

    public function create(?User $user, ?BundleContract $bundle = null)
    {
        return false;
    }

    public function viewRevisions(?User $user, Entity $entity)
    {
        return false;
    }

    public function restoreRevision(?User $user, Entity $entity)
    {
        return false;
    }
}