<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\Entity;

trait UpdatesAdminEntity
{
    use UpdatesEntity;

    /**
     * @inheritDoc
     */
    protected function onUpdateSuccess(Entity $entity)
    {
        return redirect($entity->uris()->make('index', [], adminPrefix()));
    }

    /**
     * @inheritDoc
     */
    protected function onUpdateFailure(Entity $entity, \Exception $exception)
    {
        if(env('APP_ENV') == 'local') {
            throw $exception;
        }
        \Notify::danger('Error : '.$exception->getMessage());
        return back();
    }

    /**
     * @inheritDoc
     */
    protected function afterUnchangedUpdate(Entity $entity)
    {
        \Notify::info('No changes made to '.$entity::friendlyName());
    }

    /**
     * @inheritDoc
     */
    protected function afterSuccessfullUpdate(Entity $entity)
    {
        \Notify::success($entity::friendlyName().' has been saved');
    }

}
