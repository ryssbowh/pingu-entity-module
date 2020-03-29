<?php 

namespace Pingu\Entity;

use Illuminate\Database\Eloquent\Collection;
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
    protected $mapping = [];

    /**
     * Get one or all view modes
     * 
     * @param null|int|string $viewMode
     * 
     * @return ?ViewMode|Collection
     */
    public function get($viewMode = null)
    {
        if (is_null($viewMode)) {
            return $this->all();
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
     * @return ?ViewMode
     */
    public function getById(int $id): ?ViewMode
    {
        return $this->getViewModes()->where('id', $id)->first();
    }

    /**
     * Get a view mode by its machineName
     * 
     * @param string $machineName
     * 
     * @return ?ViewMode
     */
    public function getByName(string $machineName): ?ViewMode
    {
        return $this->getViewModes()->where('machineName', $machineName)->first();
    }

    /**
     * Checks if an entity has a view mode
     * 
     * @param string              $entityType
     * @param ViewMode|int|string $viewMode
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
        foreach (ViewModeModel::all() as $viewMode) {
            $objects = $viewMode->mapping->pluck('object')->all();
            foreach ($objects as $object) { 
                $out[$object][] = $viewMode->machineName;
            }
        }
        return $out;
    }
}