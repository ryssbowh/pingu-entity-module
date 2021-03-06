<?php

namespace Pingu\Entity\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\Models\HasWeight;

class FormLayoutGroup extends BaseModel
{
    use HasWeight; 

    public $fillable = ['object', 'name', 'weight'];

    public $timestamps = false;

    protected $with = [];

    protected $layoutInstance;

    public static function boot()
    {
        parent::boot();

        static::saving(
            function ($group) {
                if (is_null($group->weight)) {
                    $group->weight = $group->getNextWeight(['object' => $group->object]);
                }
            }
        );

        static::saved(
            function ($group) {
                \FieldLayout::forgetCache($group->object);
            }
        );

        static::saved(
            function ($group) {
                \FieldLayout::forgetCache($group->object);
            }
        );

        static::deleting(
            function ($group) {
                foreach ($group->getLayout() as $layout) {
                    $layout->delete();
                }
            }
        );

        static::deleted(
            function ($group) {
                \FieldLayout::forgetCache($group->object);
                $group->resetLayout();
            }
        );
    }

    /**
     * Layout (items) relationship
     * 
     * @return HasMany
     */
    public function layout()
    {
        return $this->hasMany(FormLayout::class, 'group_id')->orderBy('weight');
    }

    /**
     * Layout getter
     * 
     * @return Collection
     */
    public function getLayout(): Collection
    {
        if (is_null($this->layoutInstance)) {
            $this->layoutInstance = $this->layout;
        }
        return $this->layoutInstance;
    }

    public function resetLayout()
    {
        $this->layoutInstance = null;
    }

    /**
     * Does this group has a $name field
     * 
     * @param string  $name
     * 
     * @return boolean
     */
    public function hasField(string $name)
    {
        return !is_null($this->getLayout()->where('field', $name)->first());
    }

    /**
     * Get a field by its name
     * 
     * @param string $name
     * 
     * @return ?FormLayout
     */
    public function getField(string $name): ?FormLayout
    {
        return $this->getLayout()->where('field', $name)->first();
    }

    /**
     * Add a FormLayout to this group
     * 
     * @param FormLayout $field
     */
    public function addField(FormLayout $field)
    {
        $this->getlayout()->push($field);
    }

    /**
     * Add a FormLayout to this group
     * 
     * @param FormLayout $field
     */
    public function deleteField(string $name)
    {
        $this->getLayout()->where('field', $name)->first()->delete();
    }
}