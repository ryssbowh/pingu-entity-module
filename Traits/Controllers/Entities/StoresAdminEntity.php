<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\BaseEntity;

trait StoresAdminEntity
{
	use StoresEntity;

	/**
	 * @inheritDoc
	 */
	protected function onStoreSuccess(BaseEntity $entity)
	{
		return redirect($entity->uris()->make('index', [], adminPrefix()));
	}

	/**
	 * @inheritDoc
	 */
	protected function afterStoreSuccess(BaseEntity $entity)
	{
		\Notify::success($entity::friendlyName().' has been created');
	}

	/**
	 * @inheritDoc
	 */
	protected function onStoreFailure(BaseEntity $entity, $exception)
	{
		if(env('APP_ENV') == 'local'){
			throw $exception;
		}
		\Notify::danger('Error while creating '.$entity::friendlyName());
		return back();
	}

}
