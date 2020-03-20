<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Pingu\Entity\Entities\Entity;

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
        $pageSize = $this->request->input('pageSize', $entity->getPerPage());
        $sortField = $this->request->input('sortField', $entity->getKeyName());
        $sortOrder = $this->request->input('sortOrder', 'asc');

        $fields = $entity->fields();
        $query = $entity->select($entity->getTable().'.*');
        foreach ($filters as $fieldName => $value) {
            if (!$fields->has($fieldName)) {
                continue;
            }
            if (!is_null($value)) {
                $fields->get($fieldName)->filterQueryModifier($query, $value, $entity);
            }
        }

        $this->modifyIndexQuery($query);

        $query->orderBy($entity->getTable().'.'.$sortField, $sortOrder);

        $entities = $query->paginate($pageSize, ['*'], 'page');

        $entities->appends($this->request->input());

        return $this->onIndexSuccess($entity, $entities);
    }

    /**
     * Response
     *
     * @param Entity     $entity
     * @param LengthAwarePaginator $entities
     * 
     * @return mixed
     */
    protected function onIndexSuccess(Entity $entity, LengthAwarePaginator $entities)
    {
    }

    /**
     * Modify the index query
     * 
     * @param Builder $query
     */
    public function modifyIndexQuery(Builder $query)
    {
    }

    /**
     * Actions before indexing
     */
    public function beforeIndex(Entity $entity)
    {
    }
}
