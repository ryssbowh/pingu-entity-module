<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\BaseEntity;

trait DeletesEntity
{
	/**
	 * Deletes an entity
	 */
	public function delete(BaseEntity $entity)
	{
		try{
			$this->beforeDeletion($entity);
			$this->performDelete($entity);
			$this->afterSuccessfullDeletion($entity);
		}
		catch(\Exception $e){
			return $this->onDeletionFailure($entity, $e);
		}

		return $this->onDeleteSuccess($entity);
	}

	/**
	 * Actions to do before mdoel is deleted
	 * 
	 * @param  BaseEntity $entity
	 */
	public function beforeDeletion(BaseEntity $entity){}

	/**
	 * Actions to do after the entity is deleted
	 * 
	 * @param  BaseEntity $entity
	 */
	public function afterSuccessfullDeletion(BaseEntity $entity){}

	/**
	 * Perform the actual deletion
	 * 
	 * @param  BaseEntity $entity
	 */
	protected function performDelete(BaseEntity $entity)
	{
		$entity->delete();
	}

	/**
	 * Response when deletion fails
	 * 
	 * @param  BaseEntity
	 * @param  \Exception $e
	 */
	protected function onDeletionFailure(BaseEntity $entity, \Exception $e){}

	/**
	 * Response when deletion succeeds
	 * 
	 * @param  BaseEntity $entity
	 */
	protected function onDeleteSuccess(BaseEntity $entity){}

}
