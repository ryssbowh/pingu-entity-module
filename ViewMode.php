<?php 

namespace Pingu\Entity;

use Illuminate\Database\Eloquent\Collection;
use Pingu\Entity\Entities\ViewMode as ViewModeModel;

class ViewMode
{
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
            return $this->resolveCache();
        }
        if (is_int($viewMode)) {
            return $this->getById($viewMode);
        } elseif (is_string($viewMode)) {
            return $this->getByName($viewMode);
        }
        return $viewMode;
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
        return $this->resolveCache()->where('id', $id)->first();
    }

    /**
     * Get a view mode by its name
     * 
     * @param string $name
     * 
     * @return ?ViewMode
     */
    public function getByName(string $name): ?ViewMode
    {
        return $this->resolveCache()->where('name', $name)->first();
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
     * Forget the entity-view mode mapping cache
     */
    public function forgetMappingCache()
    {
        \Cache::forget('entity.viewModesMapping');
    }

    /**
     * Forget the view mode cache
     */
    public function forgetCache()
    {
        \Cache::forget('entity.viewModes');
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
     * Loads the view mode - entity mapping
     * @return array
     */
    protected function loadViewModesMapping(): array
    {
        $out = [];
        foreach (ViewModeModel::all() as $viewMode) {
            $entities = $viewMode->entities->pluck('entity')->all();
            foreach ($entities as $type) {
                $out[$type][] = $viewMode->machineName;
            }
        }
        return $out;
    }
}