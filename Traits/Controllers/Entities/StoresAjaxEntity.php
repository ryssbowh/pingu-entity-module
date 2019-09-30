<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Core\Entities\BaseModel;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait StoresAjaxEntity 
{
	use StoresEntity;

	/**
	 * @inheritDoc
	 */
	protected function onStoreSuccess(BaseModel $model)
	{
		return ['model' => $model, 'message' => $model::friendlyName()." has been created"];
	}
}
