<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Core\Forms\ConfirmDeletion;
use Pingu\Entity\Support\Entity;

trait DeletesAdminEntity
{
    use DeletesEntity;

    /**
     * Confirm deletion requests
     * 
     * @param  Entity $entity
     * @return view
     */
    public function confirmDelete(Entity $entity)
    {
        \ContextualLinks::addFromObject($entity);
        $form = $entity->forms()->delete([$this->getDeleteUri($entity)]);

        $with = [
            'form' => $form, 
            'entity' => $entity
        ];
        $this->addVariablesToDeleteView($with);
        return view()->first($this->getDeleteViewNames($entity), $with);
    }

    protected function getDeleteViewNames(Entity $entity)
    {
        return ['pages.entities.'.class_machine_name($entity).'.delete', 'pages.entities.delete'];
    }

    protected function getDeleteUri(Entity $entity)
    {
        return ['url' => $entity->uris()->make('delete', $entity, adminPrefix())];
    }

    protected function addVariablesToDeleteView(&$with)
    {
    }

    /**
     * @inheritDoc
     */
    protected function onDeleteFailure(Entity $entity, \Exception $e)
    {
        if (env('APP_ENV') == 'local') {
            throw $e;
        }
        \Notify::danger('Error : '.$e->getMessage());
        return back();
    }

    /**
     * @inheritDoc
     */
    protected function onDeleteSuccess(Entity $entity)
    {
        return redirect($entity::uris()->make('index', [], adminPrefix()));
    }

    /**
     * @inheritDoc
     */
    protected function afterSuccessfullDeletion(Entity $entity)
    {
        \Notify::success($entity::friendlyName().' has been deleted');
    }

}
