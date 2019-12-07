<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\Entity;

trait DeletesEntity
{
    /**
     * @param Entity $entity
     */
    public function delete(Entity $entity)
    {
        try{
            $this->beforeDeletion($entity);
            $this->performDelete($entity);
            $this->afterSuccessfullDeletion($entity);
        }
        catch(\Exception $e){
            return $this->onDeleteFailure($entity, $e);
        }

        return $this->onDeleteSuccess($entity);
    }

    /**
     * Actions to do before entity is deleted
     * 
     * @param Entity $entity
     */
    public function beforeDeletion(Entity $entity)
    {
    }

    /**
     * Actions to do after the entity is deleted
     * 
     * @param Entity $entity
     */
    public function afterSuccessfullDeletion(Entity $entity)
    {
    }

    /**
     * Perform the actual deletion
     * 
     * @param Entity $entity
     */
    protected function performDelete(Entity $entity)
    {
        $entity->delete();
    }

    /**
     * Response when deletion fails
     * 
     * @param Entity
     * @param \Exception $e
     */
    protected function onDeleteFailure(Entity $entity, \Exception $e)
    {
    }

    /**
     * Response when deletion succeeds
     * 
     * @param Entity $entity
     */
    protected function onDeleteSuccess(Entity $entity)
    {
    }

}
