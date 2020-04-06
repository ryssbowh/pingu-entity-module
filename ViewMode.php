<?php 

namespace Pingu\Entity;

use Illuminate\Database\Eloquent\Collection;
use Pingu\Entity\Contracts\HasViewModesContract;
use Pingu\Entity\Entities\ViewMode as ViewModeModel;

class ViewMode
{   
    /**
     * View mode cache
     * @var Collection
     */
    protected $viewModes;

    /**
     * View mode - entity mapping cache
     * @var array
     */
    protected $mapping;

    /**
     * Entities which have view modes
     * @var array
     */
    protected $entities = [];

    public function registerEntity(HasViewModesContract $entity)
    {
        $this->entities[$entity->identifier()] = get_class($entity);
    }

    public function allEntities()
    {
        return $this->entities;
    }

    /**
     * Get one or some view modes
     * 
     * @param null|int|string|array $viewMode
     * 
     * @return ?ViewMode|array|Collection
     */
    public function get($viewMode = null)
    {
        if (is_null($viewMode)) {
            return $this->all();
        }
        if (is_array($viewMode)) {
            $_this = $this;
            return array_map(function ($viewMode) use ($_this) {
                return $_this->get($viewMode);
            }, $viewMode);
        }
        if (is_int($viewMode)) {
            return $this->getById($viewMode);
        } elseif (is_string($viewMode)) {
            return $this->getByName($viewMode);
        }
        return $viewMode;
    }

    /**
     * Get all view modes
     * 
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->getViewModes();
    }

    /**
     * Get a view mode by its id
     * 
     * @param int $id
     * 
     * @return ?ViewModeModel
     */
    public function getById(int $id): ?ViewModeModel
    {
        return $this->getViewModes()->where('id', $id)->first();
    }

    /**
     * Get a view mode by its machineName
     * 
     * @param string $machineName
     * 
     * @return ?ViewModeModel
     */
    public function getByName(string $machineName): ?ViewModeModel
    {
        return $this->getViewModes()->where('machineName', $machineName)->first();
    }

    /**
     * Checks if an entity has a view mode
     * 
     * @param string              $entityType
     * @param ViewModeModel|int|string $viewMode
     * 
     * @return bool
     */
    public function entityHas(string $entityType, $viewMode): bool
    {
        $viewMode = $this->get($viewMode);
        return in_array($viewMode->machineName, ($this->resolveMappingCache()[$entityType]) ?? []);
    }

    /**
     * Get all view modes for an entity
     * 
     * @return array
     */
    public function forEntity($entity): array
    {
        if (!$entity instanceof Entity) {
            $entity = new $entity;
        }
        return $this->get($this->mapping[$entity->identifier] ?? ['default']);
    }

    /**
     * Forget the entity-view mode mapping cache
     */
    public function forgetMappingCache()
    {
        \Cache::forget('entity.viewModesMapping');
        $this->mapping = null;
    }

    /**
     * Forget the view mode cache
     */
    public function forgetCache()
    {
        \Cache::forget('entity.viewModes');
        $this->viewModes = null;
    }

    /**
     * View modes getter
     * 
     * @return Collection
     */
    public function getViewModes(): Collection
    {
        if (is_null($this->viewModes)) {
            $this->viewModes = $this->resolveCache();
        }
        return $this->viewModes;
    }

    /**
     * Mapping getter
     * 
     * @return array
     */
    public function getMapping(): array
    {
        if (is_null($this->mapping)) {
            $this->mapping = $this->resolveMappingCache();
        }
        return $this->mapping;
    }

    public function getDefault()
    {
        return $this->get('default');
    }

    /**
     * Gets the entity-view mode mapping cache
     *
     * @return array
     */
    protected function resolveMappingCache(): array
    {
        if (config('entity.useCache', true)) {
            $_this = $this;
            return \Cache::rememberForever('entity.viewModesMapping', function ()  use ($_this) {
                return $_this->loadViewModesMapping();
            });
        }
        return $this->loadViewModesMapping();
    }

    /**
     * Gets the view mode cache
     *
     * @return Collection
     */
    protected function resolveCache(): Collection
    {
        if (config('entity.useCache', true)) {
            $_this = $this;
            return \Cache::rememberForever('entity.viewModes', function () use ($_this) {
                return $_this->loadViewModes();
            });
        }
        return $this->loadViewModes();
    }

    /**
     * Loads the view modes
     * 
     * @return Collection
     */
    protected function loadViewModes(): Collection
    {
        return ViewModeModel::all();
    }

    /**
     * Loads the view mode - object mapping
     * 
     * @return array
     */
    protected function loadViewModesMapping(): array
    {
        $out = [];
        foreach ($this->getViewModes() as $viewMode) {
            $out[$viewMode->machineName] = $viewMode->mapping->pluck('object')->all();
        }
        return $out;
    }
}