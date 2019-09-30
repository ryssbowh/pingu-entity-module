<?php

namespace Pingu\Entity\Contracts;

use Illuminate\Support\Arr;

abstract class Routes
{
	public function __construct($object)
	{
		$this->object = $object;
	}

	public abstract function registerRoutes();
}