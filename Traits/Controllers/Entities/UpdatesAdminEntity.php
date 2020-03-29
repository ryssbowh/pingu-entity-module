<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Support\Entity;

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
    protected function afterUnsavedUpdate(Entity $entity)
    {
        \Notify::warning($entity::friendlyName()." has not been saved");
    }

    /**
     * @inheritDoc
     */
    protected function afterSuccessfullUpdate(Entity $entity)
    {
        if (!$entity->wasChanged()) {
            \Notify::info('No changes made to '.$entity::friendlyName());
        } else {
            \Notify::success($entity::friendlyName().' has been saved');
        }
    }

}
