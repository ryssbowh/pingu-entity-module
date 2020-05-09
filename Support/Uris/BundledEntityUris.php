<?php

namespace Pingu\Entity\Support\Uris;

use Pingu\Core\Support\Uris\BaseModelUris;

class BundledEntityUris extends BaseModelUris
{
    /**
     * @inheritDoc
     */
    protected function uris(): array
    {
        return [
            'create' => '@slugs@/create/{bundle}',
            'store' => '@slugs@/create/{bundle}',
        ];
    }
}