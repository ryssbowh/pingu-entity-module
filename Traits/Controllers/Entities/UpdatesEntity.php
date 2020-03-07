<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Validation\Validator;
use Pingu\Entity\Entities\Entity;
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
            $changes = $this->performUpdate($entity, $validated);
            if ($changes) {
                $this->afterSuccessfullUpdate($entity); 
            } else {
                $this->afterUnchangedUpdate($entity);
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
     * Response when entity can't be saved
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
     * do things after a successfull update that didn't change the entity's attributes
     * 
     * @param Entity $entity
     */
    protected function afterUnchangedUpdate(Entity $entity)
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
        $validator = $this->getUpdateValidator($entity);
        $this->modifyUpdateValidator($validator);
        $validator->validate();
        $validated = $validator->validated();
        $validated = $entity->validator()->uploadMedias($validated);
        return $entity->validator()->castValues($validated);
    }

    /**
     * creates the validator for a store request
     * 
     * @return Validator
     */
    protected function getUpdateValidator(Entity $entity)
    {
        return $entity->validator()->makeValidator($this->request->except(['_method', '_token']), true);
    }

    /**
     * Modify the store request validator
     * 
     * @param Validator $validator
     */
    protected function modifyUpdateValidator(Validator $validator)
    {
    }
}
