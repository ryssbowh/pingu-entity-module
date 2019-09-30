<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Pingu\Entity\Contracts\EntityContract;

trait IndexesEntity
{
	/**
	 * Indexes models
	 * 
	 * @return mixed
	 */
	public function index()
	{
		$entity = $this->getRouteAction('entity');

		$this->beforeIndex($entity);

		$filters = $this->request->input('filters', []);
		$pageIndex = $this->request->input('pageIndex', 1);
		$pageSize = $this->request->input('pageSize', $entity->getPerPage());
		$sortField = $this->request->input('sortField', $entity->getKeyName());
		$sortOrder = $this->request->input('sortOrder', 'asc');

		$fieldsDef = $entity->buildFieldDefinitions();
		$query = $entity->newQuery();
		foreach($filters as $field => $value){
			if(!isset($fieldsDef[$field])){
				continue;
			}
			$fieldDef = $fieldsDef[$field];
			
			if(!is_null($value)){
				$fieldDef->option('type')->filterQueryModifier($query, $value);
			}
		}

		$this->modifyIndexQuery($query);

		$count = $query->count();

		if($sortField){
			$query->orderBy($sortField, $sortOrder);
		}

		$query->offset(($pageIndex-1) * $pageSize)->take($pageSize);

		$entities = $query->get();

		return $this->onIndexSuccess($entity, $entities);
	}

	/**
	 * Response
	 *
	 * @param  EntityContract $entity
	 * @param  Collection $entities
	 * @return mixed
	 */
	protected function onIndexSuccess(EntityContract $entity, Collection $entities){}

	/**
	 * Modify the index query
	 * 
	 * @param Builder $query
	 */
	public function modifyIndexQuery(Builder $query){}

	/**
	 * Actions before indexing
	 */
	public function beforeIndex(EntityContract $entity){}
}
