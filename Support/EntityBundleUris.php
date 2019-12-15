<?php

namespace Pingu\Entity\Support;

use Pingu\Core\Support\Uris;
use Pingu\Entity\Support\Bundle;
use Pingu\Field\Entities\BundleField;

class EntityBundleUris extends BaseEntityUris
{
    /**
     * @inheritDoc
     */
    protected function uris(): array
    {
        return \Uris::get(Bundle::class)->all();
    }
}