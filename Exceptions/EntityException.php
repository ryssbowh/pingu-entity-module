<?php

namespace Pingu\Entity\Exceptions;

use Pingu\Entity\Contracts\EntityContract;

class EntityException extends \Exception{

	public static function registered(EntityContract $entity)
	{
		return new static("Can't register entity '{$entity->entityType()}': name already registered");
	}

	public static function notRegistered(string $name)
	{
		return new static("'$name' is not a registered entity");
	}
}