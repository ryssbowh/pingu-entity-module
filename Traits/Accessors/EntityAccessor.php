<?php

namespace Pingu\Entity\Traits\Accessors;

trait EntityAccessor
{
	public function view(): bool
	{
		return \Permissions::getPermissionableModel()->hasPermissionTo('view '.$this->object::friendlyNames());
	}

	public function edit(): bool
	{
		return \Permissions::getPermissionableModel()->hasPermissionTo('edit '.$this->object::friendlyNames());
	}

	public function delete(): bool
	{
		return \Permissions::getPermissionableModel()->hasPermissionTo('delete '.$this->object::friendlyNames());
	}

	public function create(): bool
	{
		return \Permissions::getPermissionableModel()->hasPermissionTo('create '.$this->object::friendlyNames());
	}
}