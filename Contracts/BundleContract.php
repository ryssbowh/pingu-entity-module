<?php

namespace Pingu\Entity\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Pingu\Core\Contracts\HasActionsContract;
use Pingu\Core\Contracts\HasRoutesContract;
use Pingu\Core\Contracts\HasUrisContract;
use Pingu\Field\Contracts\DefinesFields;

interface BundleContract extends 
    DefinesFields,
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

    /**
     * The entity class this bundle is for
     * 
     * @return string
     */
    public function entityFor(): string;

    /**
     * All entities that have this bundle
     * 
     * @return Collection
     */
    public function entities(): Collection;
}