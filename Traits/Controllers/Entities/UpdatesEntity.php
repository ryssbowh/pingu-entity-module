<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Validation\Validator;
use Pingu\Entity\Entities\BaseEntity;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait UpdatesEntity
{
	/**
	 * Updates a entity
	 * 
	 * @param  BaseEntity
	 * @return response
	 */
	public function update(BaseEntity $entity)
	{	
		try{
			$this->beforeUpdate($entity);
			$validated = $this->validateUpdateRequest($entity);
			$changes = $this->performUpdate($entity, $validated);
			if($changes){
				$this->afterSuccessfullUpdate($entity);	
			}
			else{
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
	 * @param  BaseEntity $entity
	 */
	protected function beforeUpdate(BaseEntity $entity){}

	/**
	 * Performs update
	 * 
	 * @param  BaseEntity $entity
	 * @param  array     $validated
	 */
	protected function performUpdate(BaseEntity $entity, array $validated)
	{
		return $entity->saveWithRelations($validated);
	}

	/**
	 * Response when entity can't be saved
	 * 
	 * @param  BaseEntity $entity
	 * @param  ModelNotSaved $exception 
	 */
	protected function onUpdateFailure(BaseEntity $entity, \Exception $exception){}

	/**
	 * do things after a successfull update
	 * 
	 * @param  BaseEntity $entity
	 */
	protected function afterSuccessfullUpdate(BaseEntity $entity){}

	/**
	 * do things after a successfull update that didn't change the entity's attributes
	 * 
	 * @param  BaseEntity $entity
	 */
	protected function afterUnchangedUpdate(BaseEntity $entity){}

	/**
	 * Response after a successfull update
	 * 
	 * @param  BaseEntity $entity
	 * @return array
	 */
	protected function onUpdateSuccess(BaseEntity $entity){}

	/**
	 * Validates a request and return validated array
	 * 
	 * @param  BaseEntity $entity
	 * @return array
	 */
	protected function validateUpdateRequest(BaseEntity $entity)
	{
		$validator = $this->getUpdateValidator($entity);
		$this->modifyUpdateValidator($validator);
		$validator->validate();
		$validated = $validator->validated();
		return $validated;
	}

	/**
	 * creates the validator for a store request
	 * 
	 * @return Validator
	 */
	protected function getUpdateValidator(BaseEntity $entity)
	{
		return $entity->makeValidator($this->request->all(), $entity->getEditFormFields());
	}

	/**
	 * Modify the store request validator
	 * 
	 * @param  Validator $validator
	 */
	protected function modifyUpdateValidator(Validator $validator){}
}
