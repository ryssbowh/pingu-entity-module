<?php

namespace Pingu\Entity\Support\Bundle;

use Pingu\Core\Support\Actions;
use Pingu\Core\Support\Routes;
use Pingu\Core\Support\Uris;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\Actions\BaseBundleActions;
use Pingu\Entity\Support\Entity;
use Pingu\Entity\Support\Routes\BaseBundleRoutes;
use Pingu\Entity\Support\Uris\BaseBundleUris;
use Pingu\Entity\Traits\Bundle;

abstract class ModelBundle implements BundleContract
{
    use Bundle;

    protected $entity;

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Get the entity attached to this bundle
     * 
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    public function register()
    {
        \Bundle::registerBundle($this);
    }
}