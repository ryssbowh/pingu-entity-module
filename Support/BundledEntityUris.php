<?php

namespace Pingu\Entity\Support;

class BundledEntityUris extends BaseEntityUris
{
    /**
     * @inheritDoc
     */
    protected function uris(): array
    {
        return [
            'create' => '@entities/create/{bundle}',
            'store' => '@entities/create/{bundle}',
        ];
    }
}