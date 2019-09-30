<?php

namespace Pingu\Entity\Support;

use Pingu\Entity\Contracts\Accessor;
use Pingu\Entity\Traits\Accessors\EntityAccessor;

class BaseEntityAccessor extends Accessor
{
	use EntityAccessor;
}