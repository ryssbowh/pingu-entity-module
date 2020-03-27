<?php

namespace Pingu\Entity\Facades;

use Illuminate\Support\Facades\Facade;

class FieldDisplay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'entity.display';
    }

}