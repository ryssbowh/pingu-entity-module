<?php

namespace Pingu\Entity\Support\FieldDisplay;

use Illuminate\Support\Collection;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\DisplayField;
use Pingu\Entity\Entities\ViewMode;
use Pingu\Entity\Support\Entity;
use Pingu\Field\Contracts\FieldContract;
use Pingu\Field\Contracts\HasFieldsContract;

class FieldDisplay
{
    /**
     * @var object
     */
    protected $object;

    /**
     * @var boolean
     */
    protected $loaded = false;

    /**
     * @var Collection
     */
    protected $display;

    /**
     * Constructor
     * 
     * @param HasFieldsContract $object
     */
    public function __construct(HasFieldsContract $object)
    {
        $this->object = $object;
    }

    /**
     * Loads displays from db
     * 
     * @return FieldDisplay
     */
    public function load($force = false): FieldDisplay
    {
        if ($this->loaded and !$force) {
            return $this;
        }
        $this->display = $this->resolveCache();
        if ($this->display->isEmpty()) {
            $this->display = collect();
            $this->create();
        }
        $this->loaded = true;
        return $this;
    }

    /**
     * Get display items
     * 
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->display;
    }

    /**
     * Get the visible display items for a view mode
     *
     * @param ViewMode $viewMode
     * 
     * @return Collection
     */
    public function forViewMode(ViewMode $viewMode, $noHidden = false): Collection
    {
        $collection = $this->display->where('view_mode_id', $viewMode->id);
        if ($noHidden) {
            $collection = $collection->where('hidden', false);
        }
        return $collection;
    }

    /**
     * Get a field for a view mode and a name
     *
     * @param string $name
     * 
     * @return FieldContract
     */
    public function getField(string $name): FieldContract
    {
        return $this->getFields()->get($name);
    }

    /**
     * Get a display for a field and a view mode
     * 
     * @param string   $name
     * @param ViewMode $viewMode
     * 
     * @return Collection
     */
    public function forFieldAndViewMode(string $name, ViewMode $viewMode): Collection
    {
        return $this->display->where('view_mode_id', $viewMode->id)
            ->where('field', $name);
    }

    /**
     * Does a field exists
     * 
     * @param string $name
     * 
     * @return boolean
     */
    public function hasField(string $name, ViewMode $viewMode): bool
    {
        return !$this->forFieldAndViewMode($name, $viewMode)->isEmpty();
    }

    /**
     * Creates field displays in database, will not recreate existing displays
     */
    public function create()
    {
        foreach ($this->getFields() as $field) {
            $this->createForField($field);
        }
    }

    /**
     * Create a DisplayField model for a field
     * 
     * @param FieldContract   $field
     */
    public function createForField(FieldContract $field, $label = true)
    {
        foreach (\ViewMode::forObject($this->object) as $viewMode) {
            if ($this->hasField($field->machineName(), $viewMode)) {
                continue;
            }
            $this->createFieldDisplay($field, $viewMode, $label);
        }
    }

    /**
     * Delete display for one field
     * 
     * @param FieldContract $field
     */
    public function deleteForField(FieldContract $field)
    {
        foreach (\ViewMode::forObject($this->object) as $viewMode) {
            if ($display = $this->forFieldAndViewMode($field->machineName(), $viewMode)->first()) {
                $display->delete();
            }
        }
    }

    /**
     * Deletes all displays for a view mode
     * 
     * @param ViewMode $viewMode
     */
    public function deleteForViewMode(ViewMode $viewMode)
    {
        foreach ($this->forViewMode($viewMode) as $display) {
            $display->delete();
        }
    }

    /**
     * Creates all displays for a view mode
     * 
     * @param ViewMode $viewMode
     */
    public function createForViewMode(ViewMode $viewMode)
    {
        foreach ($this->getFields() as $field) {
            $this->createFieldDisplay($field, $viewMode);
        }
    }

    /**
     * Delete all fields display
     */
    public function delete()
    {
        foreach ($this->display as $display) {
            $display->delete();
        }
    }

    /**
     * Does this layout have any field
     * 
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->display->isEmpty();
    }

    /**
     * Object getter
     * 
     * @return HasFieldsContract
     */
    public function getObject(): HasFieldsContract
    {
        return $this->object;
    }

    /**
     * Builds the field display for rendering
     * 
     * @param ViewMode $viewMode
     * @param Entity $entity
     * 
     * @return Collection
     */
    public function buildForRendering(ViewMode $viewMode, Entity $entity): Collection
    {
        return $this->forViewMode($viewMode, true)->map(
            function ($display) use ($entity) {
                return $display->getRenderer($entity);
            }
        );
    }

    /**
     * Get the fields defined by the associated object
     * 
     * @return Collection
     */
    protected function getFields(): Collection
    {
        return $this->object->fields()->get();
    }

    /**
     * Creates a field display for a field and a view mode
     * 
     * @param FieldContract $field
     * @param ViewMode      $viewMode
     * @param boolean       $label
     * 
     * @return DisplayField
     */
    protected function createFieldDisplay(FieldContract $field, ViewMode $viewMode, $label = true): DisplayField
    {
        $display = new DisplayField;
        $displayer = $field::defaultDisplayer();
        $display->fill([
            'field' => $field->machineName(),
            'object' => $this->object->identifier(),
            'displayer' => $displayer::machineName(),
            'options' => $displayer::hasOptions() ? (new $displayer($display))->options()->values() : [],
            'label' => $label
        ])->view_mode()->associate($viewMode);
        $display->save();
        $this->display->push($display);
        return $display;
    }

    /**
     * Resolve display cache
     * 
     * @return Collection
     */
    protected function resolveCache()
    {
        $_this = $this;
        return \FieldDisplay::getCache($this->object, function () use ($_this) {
            return $_this->loadDisplay();
        });
    }

    /**
     * Get displays from db
     * 
     * @return Collection
     */
    protected function loadDisplay()
    {
        return DisplayField::where('object', $this->object->identifier())
            ->orderBy('weight')
            ->get();
    }
}