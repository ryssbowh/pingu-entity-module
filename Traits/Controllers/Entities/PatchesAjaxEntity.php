<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait PatchesAjaxEntity 
{
	use PatchesEntity;

	/**
	 * @inheritDoc
	 */
	protected function onPatchSuccess(Collection $models)
	{
		return ['models' => $models->toArray(), 'message' => $this->model::friendlyNames().' have been saved'];
	}

}
