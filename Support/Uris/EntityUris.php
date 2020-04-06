<?php

namespace Pingu\Entity\Support\Uris;

use Pingu\Core\Support\Uris;

class EntityUris extends Uris
{
    /**
     * @inheritDoc
     */
    protected function uris(): array
    {
        return [
            'index' => '@entities',
            'view' => '@entity/{@entity}',
            'create' => '@entities/create',
            'store' => '@entities',
            'confirmDelete' => '@entity/{@entity}/delete',
            'delete' => '@entity/{@entity}/delete',
            'edit' => '@entity/{@entity}/edit',
            'update' => '@entity/{@entity}',
            'patch' => '@entities',
            'indexRevisions' => '@entity/{@entity}/revisions',
            'editRevision' => '@entity/{@entity}/revision/{id}',
        ];
    }
}