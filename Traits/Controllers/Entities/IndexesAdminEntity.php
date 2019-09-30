<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Database\Eloquent\Collection;
use Pingu\Entity\Contracts\EntityContract;

trait IndexesAdminEntity 
{
	use IndexesEntity;

	/**
	 * @inheritDoc
	 */
	protected function onIndexSuccess(EntityContract $entity, Collection $entities)
	{
		return $this->getIndexView($entity, $entities);
	}

	/**
	 * Get the view for a create request
	 *
	 * @param  EntityContract $entity
	 * @param  Collection $entities
	 * @return view
	 */
	protected function getIndexView(EntityContract $entity, Collection $entities)
	{
		$canCreate = $entity->accessor()->create();
		$createUrl = $entity->uris()->make('create', [], adminPrefix());
		$with = [
			'total' => $entities->count(),
			'entities' => $entities,
			'entity' => $entity,
			'canCreate' => $canCreate,
			'createUrl' => $createUrl
		];
		$this->addVariablesToIndexView($with);
		return view($this->getIndexViewName($entity))->with($with);
	}

	/**
	 * View name for creating models
	 *
	 * @param  EntityContract $entity
	 * @return string
	 */
	protected function getIndexViewName(EntityContract $entity)
	{
		return 'entity::indexEntities';
	}

	/**
	 * Callback to add variables to the view
	 * 
	 * @param array &$with
	 */
	protected function addVariablesToIndexView(array &$with){}
}
