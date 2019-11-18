<?php
namespace Pingu\Entity\Facades;

use Illuminate\Support\Facades\Facade;

class Bundle extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'entity.bundle';
    }
}