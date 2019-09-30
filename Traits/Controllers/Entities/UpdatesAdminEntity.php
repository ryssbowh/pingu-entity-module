<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\BaseEntity;

trait UpdatesAdminEntity
{
	use UpdatesEntity;

	/**
	 * @inheritDoc
	 */
	protected function onUpdateSuccess(BaseEntity $entity)
	{
		return redirect($entity->uris()->make('index', [], adminPrefix()));
	}

	/**
	 * @inheritDoc
	 */
	protected function onUpdateFailure(BaseEntity $entity, \Exception $exception)
	{
		if(env('APP_ENV') == 'local'){
			throw $exception;
		}
		\Notify::danger('Error : '.$exception->getMessage());
		return back();
	}

	/**
	 * @inheritDoc
	 */
	protected function afterUnchangedUpdate(BaseEntity $entity)
	{
		\Notify::info('No changes made to '.$entity::friendlyName());
	}

	/**
	 * @inheritDoc
	 */
	protected function afterSuccessfullUpdate(BaseEntity $entity)
	{
		\Notify::success($entity::friendlyName().' has been saved');
	}

}
