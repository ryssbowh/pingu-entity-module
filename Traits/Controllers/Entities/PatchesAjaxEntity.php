<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Support\Collection;
use Pingu\Entity\Support\Entity;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait PatchesAjaxEntity
{
    use PatchesEntity;

    /**
     * @inheritDoc
     */
    protected function onPatchSuccess(Entity $entity, Collection $models)
    {
        return ['models' => $models->toArray(), 'message' => $entity::friendlyNames().' have been saved'];
    }

}
