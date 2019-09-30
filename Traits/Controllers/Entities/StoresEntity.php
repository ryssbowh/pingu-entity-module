<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Validation\Validator;
use Pingu\Entity\Entities\BaseEntity;

trait StoresEntity
{
	/**
	 * Stores a new entity, entity must be set within the route
	 * 
	 * @return redirect
	 */
	public function store()
	{
		$entity = $this->getRouteAction('entity');

		try{
			$this->beforeStore($entity);
			$validated = $this->validateStoreRequest($entity);
			$this->performStore($entity, $validated);
			$this->afterStoreSuccess($entity);
		}
		catch(\Exception $e){
			return $this->onStoreFailure($entity, $e);
		}

		return $this->onStoreSuccess($entity);
	}

	/**
	 * Store the entity
	 * 
	 * @param  BaseEntity $entity
	 * @param  array     $validated
	 */
	protected function performStore(BaseEntity $entity, array $validated)
	{
		$entity->saveWithRelations($validated);
	}

	/**
	 * Callback before store request
	 *
	 * @param BaseEntity $entity
	 */
	protected function beforeStore(BaseEntity $entity){}

	/**
	 * Validates a request and return validated array
	 * 
	 * @param  BaseEntity $entity
	 * @return array
	 */
	protected function validateStoreRequest(BaseEntity $entity)
	{
		$validator = $this->getStoreValidator($entity);
		$this->modifyStoreValidator($validator);
		$validator->validate();
		$validated = $validator->validated();
		return $validated;
	}

	/**
	 * creates the validator for a store request
	 * 
	 * @return Validator
	 */
	protected function getStoreValidator(BaseEntity $entity)
	{
		$fields = $entity->getAddFormFields();
		return $entity->makeValidator($this->request->all(), $fields);
	}

	/**
	 * Modify the store request validator
	 * 
	 * @param  Validator $validator
	 */
	protected function modifyStoreValidator(Validator $validator){}

	/**
	 * Do stuff after a entity has been stored
	 * 
	 * @param  BaseEntity $entity
	 */
	protected function afterStoreSuccess(BaseEntity $entity){}

	/**
	 * Returns response when store fails
	 * 
	 * @param  BaseEntity  $entity
	 * @param  \Exception $exception
	 * @return mixed
	 */
	protected function onStoreFailure(BaseEntity $entity, \Exception $exception){
		throw $exception;
	}

	/**
	 * Returns reponse when store succeeds
	 * 
	 * @param  BaseEntity $entity
	 * @return mixed
	 */
	protected function onStoreSuccess(BaseEntity $entity){}

}
