<?php

namespace Pingu\Entity\Traits;

use Pingu\Entity\Contracts\Accessor;
use Pingu\Entity\Contracts\Actions;
use Pingu\Entity\Contracts\Uris;
use Pingu\Entity\Events\EntityBundleDeleted;
use Pingu\Entity\Support\BaseEntityBundleAccessor;
use Pingu\Entity\Support\BaseEntityBundleActions;
use Pingu\Entity\Support\BaseEntityBundleUris;

trait EntityBundle
{
	use Bundle;

	public static function bootEntityBundle()
	{
		// static::creating(function($model){
		// 	$model->entityType()->createDefaultFields($model);
		// });

		static::deleted(function($model){
			event(new EntityBundleDeleted($model));
		});
	}

    public function actions(): Actions
    {
        return new BaseEntityBundleActions($this);
    }

    public function bundleUris(): Uris
    {
        return new BaseEntityBundleUris($this);
    }

    public function accessor(): Accessor
    {
    	return new BaseEntityBundleAccessor($this);
    }

}