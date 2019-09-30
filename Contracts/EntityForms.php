<?php

namespace Pingu\Entity\Contracts;

use Pingu\Entity\Contracts\EntityContract;
use Pingu\Forms\Support\Form;

abstract class EntityForms
{
	public function __construct(EntityContract $entity)
	{
		$this->entity = $entity;
	}

	abstract public function create(array $action): Form;

	abstract public function edit(array $action): Form;

	abstract public function delete(array $action): Form;
}