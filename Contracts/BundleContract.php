<?php

namespace Pingu\Entity\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Pingu\Core\Contracts\HasActionsContract;
use Pingu\Core\Contracts\HasPolicyContract;
use Pingu\Core\Contracts\HasRoutesContract;
use Pingu\Core\Contracts\HasUrisContract;
use Pingu\Entity\Support\FieldDisplay\FieldDisplay;
use Pingu\Entity\Support\FieldLayout\FieldLayout;
use Pingu\Field\Contracts\HasFieldsContract;

interface BundleContract extends 
    HasFieldsContract,
    HasActionsContract,
    HasPolicyContract,
    HasRoutesContract,
    HasUrisContract
{
    /**
     * Machine name
     * 
     * @return string
     */
    public function name(): string;

    /**
     * Friendly name
     * 
     * @return string
     */
    public function friendlyName(): string;

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

    /**
     * Get the layout class for this bundle
     * 
     * @return FieldLayout
     */
    public function fieldLayout(): FieldLayout;

    /**
     * Get the field display class for this bundle
     * 
     * @return FieldDisplay
     */
    public function fieldDisplay(): FieldDisplay;
}