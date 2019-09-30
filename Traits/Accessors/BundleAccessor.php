<?php

namespace Pingu\Entity\Traits\Accessors;

trait BundleAccessor
{
	public function indexFields(): bool
	{
		return \Permissions::getPermissionableModel()->hasPermissionTo('manages bundles');
	}

	public function editFields(): bool
	{
		return \Permissions::getPermissionableModel()->hasPermissionTo('manages bundles');
	}

	public function deleteFields(): bool
	{
		return \Permissions::getPermissionableModel()->hasPermissionTo('manages bundles');
	}

	public function createFields(): bool
	{
		return \Permissions::getPermissionableModel()->hasPermissionTo('manages bundles');
	}
}