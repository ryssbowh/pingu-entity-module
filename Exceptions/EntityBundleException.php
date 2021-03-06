<?php

namespace Pingu\Entity\Exceptions;

use Pingu\Entity\Contracts\BundleContract;

class EntityBundleException extends \Exception
{

    public static function registered(BundleContract $bundle)
    {
        return new static("Can't register bundle ".get_class($bundle)." : name already registered");
    }

    public static function notRegistered(string $name)
    {
        return new static("'$name' is not a registered entity bundle");
    }

    public static function fromEntity(Entity $entity)
    {
        return new static("Cannot access {get_class($entity)} as bundle, entity doesn't exist");
    }
}