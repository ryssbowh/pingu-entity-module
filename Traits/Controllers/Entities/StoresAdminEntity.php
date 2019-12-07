<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\Entity;

trait StoresAdminEntity
{
    use StoresEntity;

    /**
     * @inheritDoc
     */
    protected function onStoreSuccess(Entity $entity)
    {
        return redirect($entity->uris()->make('index', [], adminPrefix()));
    }

    /**
     * @inheritDoc
     */
    protected function afterStoreSuccess(Entity $entity)
    {
        \Notify::success($entity::friendlyName().' has been created');
    }

    /**
     * @inheritDoc
     */
    protected function onStoreFailure(Entity $entity, $exception)
    {
        if(env('APP_ENV') == 'local') {
            throw $exception;
        }
        \Notify::danger('Error while creating '.$entity::friendlyName());
        return back();
    }

}
