<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Database\Eloquent\Collection;

trait IndexesAjaxEntity
{
    use IndexesEntity;

    /**
     * @inheritDoc
     */
    protected function onIndexSuccess(string $entity, Collection $entities)
    {
        return ['entities' => $entities->toArray(), 'total' => $entities->count()];
    }
}
