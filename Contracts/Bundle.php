<?php

namespace Pingu\Entity\Contracts;

use Pingu\Entity\Contracts\Actions;
use Pingu\Entity\Contracts\Uris;
use Pingu\Entity\Support\BaseBundleActions;
use Pingu\Entity\Support\BaseBundleUris;
use Pingu\Entity\Traits\Bundle as BundleTrait;

abstract class Bundle implements BundleContract
{
	use BundleTrait;

	public function bundleUris(): Uris
    {
        return new BaseBundleUris($this);
    }

    public function actions(): Actions
    {
        return new BaseBundleActions($this);
    }

    public function getRouteKey()
	{
		return $this->bundleName();
	}
}