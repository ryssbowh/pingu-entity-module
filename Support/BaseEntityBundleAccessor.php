<?php

namespace Pingu\Entity\Support;

use Pingu\Entity\Contracts\Accessor;
use Pingu\Entity\Traits\Accessors\BundleAccessor;
use Pingu\Entity\Traits\Accessors\EntityAccessor;

class BaseEntityBundleAccessor extends Accessor
{
	use EntityAccessor, BundleAccessor;
}