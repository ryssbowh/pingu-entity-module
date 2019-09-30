<?php

namespace Pingu\Entity\Contracts;

use Pingu\Entity\Traits\AccessUris;

abstract class Uris
{
	use AccessUris;

	public function __construct($object)
	{
		$this->object = $object;
	}
}