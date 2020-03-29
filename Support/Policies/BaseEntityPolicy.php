<?php

namespace Pingu\Entity\Support\Policies;

use Pingu\Core\Support\Policy;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\Entity;
use Pingu\User\Entities\User;

class BaseEntityPolicy extends Policy
{
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