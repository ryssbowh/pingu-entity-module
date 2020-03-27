<?php

namespace Pingu\Entity\Facades;

use Illuminate\Support\Facades\Facade;

class FieldLayout extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'entity.layout';
    }

}