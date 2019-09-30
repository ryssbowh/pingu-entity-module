<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Core\Forms\ConfirmDeletion;
use Pingu\Entity\Entities\BaseEntity;

trait DeletesAdminEntity
{
	use DeletesEntity;

	/**
	 * Confirm deletion requests
	 * 
	 * @param  BaseEntity $entity
	 * @return view
	 */
	public function confirmDelete(BaseEntity $entity)
	{
		\ContextualLinks::addFromObject($entity);
		$form = $entity->forms()->delete($this->getDeleteUri($entity));

		$with = [
			'form' => $form, 
			'entity' => $entity
		];
		$this->addVariablesToDeleteView($with);
		return view('entity::deleteEntity')->with($with);
	}

	protected function getDeleteUri(BaseEntity $entity)
	{
		return ['url' => $entity->uris()->make('delete', $entity, adminPrefix())];
	}

	protected function addVariablesToDeleteView(&$with){}

	/**
	 * @inheritDoc
	 */
	protected function onDeleteFailure(BaseEntity $entity, \Exception $e)
	{
		if(env('APP_ENV') == 'local'){
			throw $e;
		}
		\Notify::danger('Error : '.$e->getMessage());
		return back();
	}

	/**
	 * @inheritDoc
	 */
	protected function onDeleteSuccess(BaseEntity $entity)
	{
		return redirect($entity->uris()->make('index', [], adminPrefix()));
	}

	/**
	 * @inheritDoc
	 */
	protected function afterSuccessfullDeletion(BaseEntity $entity){
		\Notify::success($entity::friendlyName().' has been deleted');
	}

}
