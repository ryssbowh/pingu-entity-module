<?php

namespace Pingu\Entity\Exceptions;

use Pingu\Entity\Entities\BundleField;

class BundleFieldException extends \Exception{

	public static function registered(string $name, string $class, string $class2)
	{
		return new static("Can't register $class as bundle : '$name' is already registered by $class2");
	}

	public static function notRegistered(string $name)
	{
		return new static("'$name' is not a registered bundle field");
	}

	public static function notDefined(string $name, string $bundle)
	{
		return new static("'$name' is not a field defined on bundle '$bundle'");
	}

	public static function notTypeDefined(string $name, string $type)
	{
		return new static("'$name' is not a field defined on entity type '$type'");
	}

	public static function alreadyDefined(BundleFieldContract $field, string $name)
	{
		return new static("Cannot add field '$name' from bundle field {$field::friendlyName()}, $name is already defined in ".BundleField::class);
	}

	public static function slugNotSetInRoute()
	{
		return new static("bundle field slug (".BundleField::routeSlug().") must be set in route");
	}

}