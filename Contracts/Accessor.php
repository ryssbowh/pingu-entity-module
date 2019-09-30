<?php

namespace Pingu\Entity\Contracts;

abstract class Accessor
{
	public function __construct($object)
	{
		$this->object = $object;
	}
}