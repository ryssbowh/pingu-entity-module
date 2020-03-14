<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

trait IndexesAjaxEntity
{
    use IndexesEntity;

    /**
     * @inheritDoc
     */
    protected function onIndexSuccess(string $entity, LengthAwarePaginator $entities)
    {
        return ['entities' => $entities->toArray(), 'total' => $entities->count()];
    }
}
