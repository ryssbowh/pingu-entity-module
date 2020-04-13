<?php 

namespace Pingu\Entity;

use Illuminate\Database\Eloquent\Collection;
use Pingu\Core\Contracts\HasIdentifierContract;
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
    protected $objects = [];

    public function registerObject(HasIdentifierContract $object)
    {
        $this->objects[$object->identifier()] = $object;
    }

    public function allObjects()
    {
        return $this->objects;
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
        if (is_numeric($viewMode)) {
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
     * Get all non default view modes
     * 
     * @return Collection
     */
    public function allNonDefault(): Collection
    {
        return $this->getViewModes()->where('machineName', '!=', 'default');
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
     * Get all view modes for an entity
     * 
     * @return array
     */
    public function forObject(HasIdentifierContract $object): array
    {
        $viewModes = [];
        foreach ($this->getMapping() as $name => $objects) {
            if (in_array($object->identifier(), $objects)) {
                $viewModes[] = $name;
            }
        }
        array_unshift($viewModes, 'default');
        return $this->get($viewModes);
    }

    /**
     * Forget the entity-view mode mapping cache
     */
    public function forgetMappingCache()
    {
        \Cache::forget(config('entity.cache-keys.view-mode-mapping'));
        $this->mapping = null;
    }

    /**
     * Forget the view mode cache
     */
    public function forgetCache()
    {
        \Cache::forget(config('entity.cache-keys.view-mode'));
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
     * Get default view mode
     * 
     * @return ViewMode
     */
    public function getDefault(): ViewMode
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
            return \Cache::rememberForever(config('entity.cache-keys.view-mode-mapping'), function ()  use ($_this) {
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
        if (config('entity.useCache', false)) {
            $_this = $this;
            return \Cache::rememberForever(config('entity.cache-keys.view-mode'), function () use ($_this) {
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
        foreach ($this->allNonDefault() as $viewMode) {
            $out[$viewMode->machineName] = $viewMode->mapping->pluck('object')->all();
        }
        return $out;
    }
}