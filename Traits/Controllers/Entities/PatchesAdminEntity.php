<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait PatchesAdminEntity 
{
	use PatchesEntity;

	/**
	 * @inheritDoc
	 */
	protected function onPatchSuccess(Collection $models)
	{
		return redirect($this->getModel()::makeUri('index', [], adminPrefix()));
	}

	/**
	 * @inheritDoc
	 */
	protected function afterSuccessfullPatch(Collection $models){
		\Notify::success($this->getModel()::friendlyNames().' have been saved');
	}

	/**
	 * @inheritDoc
	 */
	protected function onPatchFailure(\Exception $e)
	{
		if(env('APP_ENV') == 'local'){
			throw $e;
		}
		\Notify::danger('Error while saving : '.$this->getModel()::friendlyName());
		return back();
	}
}
