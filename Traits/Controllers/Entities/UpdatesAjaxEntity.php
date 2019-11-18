<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\Entity;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait UpdatesAjaxEntity
{
    use UpdatesEntity;

    /**
     * @inheritDoc
     */
    protected function onUpdateFailure(Entity $entity, \Exception $exception)
    {
        if (env('APP_ENV') == 'local') {
            throw $exception;
        }
        throw new HttpException(422, $exception->getMessage());
    }

    /**
     * @inheritDoc
     */
    protected function onUpdateSuccess(Entity $entity)
    {
        return ['entity' => $entity, 'message' => $entity::friendlyname().' has been updated'];
    }
}
