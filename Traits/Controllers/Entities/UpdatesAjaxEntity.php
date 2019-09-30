<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Core\Entities\BaseModel;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait UpdatesAjaxEntity
{
	use UpdatesEntity;

	/**
	 * @inheritDoc
	 */
	protected function onUpdateFailure(BaseModel $model, \Exception $exception)
	{
		throw new HttpException(422, $exception->getMessage());
	}

	/**
	 * @inheritDoc
	 */
	protected function onUpdateSuccess(BaseModel $model)
	{
		return ['model' => $model, 'message' => $model::friendlyname().' has been updated'];
	}
}
