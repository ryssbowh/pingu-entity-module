<?php

namespace Pingu\Entity\Contracts;

use Pingu\Core\Contracts\HasActionsContract;
use Pingu\Core\Contracts\HasPolicyContract;
use Pingu\Core\Contracts\HasRouteSlugContract;
use Pingu\Core\Contracts\HasRoutesContract;
use Pingu\Core\Contracts\RenderableContract;

interface EntityContract extends 
    HasActionsContract,
    HasRoutesContract,
    HasPolicyContract,
    HasRouteSlugContract,
    RenderableContract   
{
}