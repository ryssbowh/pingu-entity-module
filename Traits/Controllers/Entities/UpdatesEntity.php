<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Validation\Validator;
use Pingu\Entity\Support\Entity;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait UpdatesEntity
{
    /**
     * Updates a entity
     * 
     * @param  Entity
     * @return response
     */
    public function update(Entity $entity)
    {   
        try{
            $this->beforeUpdate($entity);
            $validated = $this->validateUpdateRequest($entity);
            $success = $this->performUpdate($entity, $validated);
            if ($success) {
                $this->afterSuccessfullUpdate($entity); 
            } else {
                $this->afterUnsavedUpdate($entity);
            }
        }
        catch(\Exception $e){
            $this->onUpdateFailure($entity, $e);
        }

        return $this->onUpdateSuccess($entity);
    }

    /**
     * Do stuff before updating
     * 
     * @param Entity $entity
     */
    protected function beforeUpdate(Entity $entity)
    {
    }

    /**
     * Performs update
     * 
     * @param Entity $entity
     * @param array  $validated
     */
    protected function performUpdate(Entity $entity, array $validated)
    {
        return $entity->saveWithRelations($validated);
    }

    /**
     * Response when an error has been met during saving
     * 
     * @param Entity     $entity
     * @param \Exception $exception 
     */
    protected function onUpdateFailure(Entity $entity, \Exception $exception)
    {
    }

    /**
     * do things after a successfull update
     * 
     * @param Entity $entity
     */
    protected function afterSuccessfullUpdate(Entity $entity)
    {
    }

    /**
     * do things after an update that has not been saved
     * 
     * @param Entity $entity
     */
    protected function afterUnsavedUpdate(Entity $entity)
    {
    }

    /**
     * Response after a successfull update
     * 
     * @param Entity $entity
     * 
     * @return array
     */
    protected function onUpdateSuccess(Entity $entity)
    {
    }

    /**
     * Validates a request and return validated array
     * 
     * @param Entity $entity
     * 
     * @return array
     */
    protected function validateUpdateRequest(Entity $entity)
    {
        return $entity->validator()->validateUpdateRequest($this->request);
    }
}
