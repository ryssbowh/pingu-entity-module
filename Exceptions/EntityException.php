<?php

namespace Pingu\Entity\Exceptions;

use Pingu\Entity\Support\Entity;

class EntityException extends \Exception
{
    public static function registered(Entity $entity)
    {
        return new static("Can't register entity '".get_class($entity)."': identifier ({$entity->identifier()}) already registered");
    }

    public static function notRegistered(string $name)
    {
        return new static("'$name' is not a registered entity");
    }

    public static function bundleNotSet(Entity $entity)
    {
        return new static("You must set the bundle of ".get_class($entity)." with \$entity->setBundle(BundleContract \$bundle) before accessing its fields");
    }
}