<?php

namespace Pingu\Entity\Exceptions;

use Pingu\Entity\Entities\Entity;

class EntityException extends \Exception
{

    public static function registered(Entity $entity)
    {
        return new static("Can't register entity '{$entity->entityType()}': name already registered");
    }

    public static function notRegistered(string $name)
    {
        return new static("'$name' is not a registered entity");
    }

    public static function bundleNotSet(Entity $entity)
    {
        return new static("You must set the bundle of ".get_class($entity)." with \$entity->fields()->setBundle(BundleContract \$bundle) before accessing its fields");
    }
}