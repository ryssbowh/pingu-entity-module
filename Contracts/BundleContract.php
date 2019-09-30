<?php

namespace Pingu\Entity\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Pingu\Entity\Contracts\Routes;
use Pingu\Entity\Contracts\Uris;
use Pingu\Entity\Entities\BundleField;
use Pingu\Forms\Support\Field;

interface BundleContract extends HasActionsContract, HasAccessorContract
{
	/**
     * Name for this bundle
     *
     * @return string
     */
    public function bundleName(): string;

    public function bundleFriendlyName(): string;

    public function bundleUris(): Uris;

    public function bundleRoutes(): Routes;

    public function getRouteKey();

	/**
	 * Fields associated to this bundle
	 * 
	 * @return Collection
	 */
	public function bundleFields(): Collection;

	/**
	 * Build a form field class
	 * 
	 * @param  string $name
	 * @return Field
	 */
	public function buildBundleFieldClass(string $name): Field;

	public function getEntityBundleField(string $name): BundleField;

}