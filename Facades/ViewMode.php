<?php

namespace Pingu\Entity\Facades;

use Illuminate\Support\Facades\Facade;

class ViewMode extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'entity.viewMode';
    }

}