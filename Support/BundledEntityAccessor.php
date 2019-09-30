<?php

namespace Pingu\Entity\Support;

use Illuminate\Support\Str;
use Pingu\Entity\Contracts\EntityAccessorBase;
use Pingu\Entity\Contracts\BundleContract;

class BundledEntityAccessor extends EntityAccessorBase
{
	public function view(): bool
	{
		return \Permissions::getPermissionableModel()::hasPermission('view '.Str::plural($this->entity->bundle()->bundleName()));
	}

	public function edit(): bool
	{
		return \Permissions::getPermissionableModel()::hasPermission('edit '.Str::plural($this->entity->bundle()->bundleName()));
	}

	public function delete(): bool
	{
		return \Permissions::getPermissionableModel()::hasPermission('delete '.Str::plural($this->entity->bundle()->bundleName()));
	}

	public function create(BundleContract $bundle): bool
	{
		return \Permissions::getPermissionableModel()::hasPermission('create '.Str::plural($bundle->bundleName()));
	}
}