<?php
namespace Pingu\Entity\Facades;

use Illuminate\Support\Facades\Facade;

class Entity extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'entity.entity';
    }
}