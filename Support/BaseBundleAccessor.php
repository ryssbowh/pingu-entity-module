<?php

namespace Pingu\Entity\Support;

use Pingu\Entity\Contracts\Accessor;
use Pingu\Entity\Traits\Accessors\BundleAccessor;

class BaseBundleAccessor extends Accessor
{
	use BundleAccessor;
}