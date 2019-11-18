<?php

namespace Pingu\Entity\Contracts;

use Pingu\Core\Contracts\HasActionsContract;
use Pingu\Core\Contracts\HasRoutesContract;
use Pingu\Core\Contracts\HasUrisContract;
use Pingu\Field\Contracts\HasFields;

interface BundleContract extends 
    HasFields,
    HasActionsContract,
    HasUrisContract,
    HasRoutesContract
{
    /**
     * Machine name
     * 
     * @return string
     */
    public function bundleName(): string;

    /**
     * Friendly name
     * 
     * @return string
     */
    public function bundleFriendlyName(): string;

    /**
     * Route key name
     * 
     * @return string
     */
    public function getRouteKey(): string;
}