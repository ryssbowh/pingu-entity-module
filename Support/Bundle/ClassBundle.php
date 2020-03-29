<?php

namespace Pingu\Entity\Support\Bundle;

use Pingu\Core\Support\Actions;
use Pingu\Core\Support\Uris;
use Pingu\Core\Traits\HasActionsThroughFacade;
use Pingu\Core\Traits\HasRoutesThroughFacade;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\FieldDisplay\FieldDisplay;
use Pingu\Entity\Support\FieldLayout\FieldLayout;
use Pingu\Entity\Traits\Bundle;
use Pingu\Field\Contracts\FieldContract;

abstract class ClassBundle implements BundleContract
{
    use Bundle;

    /**
     * Registers this bundle
     */
    public static function register()
    {
        \Bundle::registerBundle(new static);
    }
}