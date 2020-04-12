<?php

namespace Pingu\Entity\Support\FieldDisplay;

use Illuminate\Support\Collection;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\DisplayField;
use Pingu\Entity\Entities\ViewMode;
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
            ->get()
            ->keyBy(function ($item) {
                return $item->field;
            });
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
    public function forViewMode(ViewMode $viewMode): Collection
    {
        return $this->display->where('hidden', false)->where('view_mode_id', $viewMode->id);
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
     * Does a field exists
     * 
     * @param string $name
     * 
     * @return boolean
     */
    public function hasField(string $name): bool
    {
        return $this->display->has($name);
    }

    /**
     * Creates field displays in database, will not recreate existing displays
     */
    public function create($viewMode = 'default')
    {
        $viewMode = \ViewMode::get($viewMode);
        foreach ($this->getFields() as $field) {
            $this->createForField($field, $viewMode);
        }
    }

    /**
     * Create a DisplayField model for a field
     * 
     * @param FieldContract   $field
     * 
     * @return bool
     */
    public function createForField(FieldContract $field, ViewMode $viewMode, $label = true): bool
    {
        if ($this->hasField($field->machineName())) {
            return false;
        }
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
        $this->display->put($field->machineName(), $display);
        return true;
    }

    /**
     * Delete display for one field
     * 
     * @param FieldContract $field
     */
    public function deleteForField(FieldContract $field)
    {
        if ($this->hasField($field->machineName())) {
            $this->display[$field->machineName()]->delete();
            $this->display->forget($field->machineName());
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
     * Get the fields defined by the associated object
     * 
     * @return Collection
     */
    protected function getFields(): Collection
    {
        return $this->object->fields()->get();
    }
}