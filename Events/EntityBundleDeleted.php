<?php

namespace Pingu\Entity\Events;

use Pingu\Entity\Contracts\BundleContract;

class EntityBundleDeleted
{
    public $bundle;

    public function __construct(BundleContract $bundle)
    {
        $this->bundle = $bundle;
    }
}