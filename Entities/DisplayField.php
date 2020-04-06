<?php

namespace Pingu\Entity\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Pingu\Core\Contracts\HasRouteSlugContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\Models\HasRouteSlug;
use Pingu\Core\Traits\Models\HasWeight;
use Pingu\Entity\Entities\ViewMode;
use Pingu\Entity\Support\Entity;
use Pingu\Entity\Support\FieldDisplay\FieldDisplay;
use Pingu\Field\Contracts\FieldContract;
use Pingu\Field\Contracts\FieldDisplayerContract;
use Pingu\Field\Renderers\EntityFieldRenderer;

class DisplayField extends BaseModel implements HasRouteSlugContract
{
    use HasWeight, HasRouteSlug;

    public $fillable = ['object', 'field', 'weight', 'hidden', 'options', 'displayer', 'label'];

    public $timestamps = false;

    public $casts = [
        'options' => 'array',
        'hidden' => 'bool',
        'label' => 'bool'
    ];

    protected $with = ['view_mode'];

    /**
     * Options instance
     * @var FieldOptions
     */
    protected $optionsInstance;

    /**
     * @inheritDoc
     */
    public static function boot()
    {
        parent::boot();

        static::saving(
            function ($display) {
                if (is_null($display->weight)) {
                    $display->weight = $display->getNextWeight(['object' => $display->object]);
                }
            }
        );

        static::saved(
            function ($display) {
                \FieldDisplay::forgetCache($display->object);
            }
        );

        static::deleted(
            function ($display) {
                \FieldDisplay::forgetCache($display->object);
            }
        );
    }

    /**
     * Displayer accessor
     * 
     * @return FieldDisplayerContract
     */
    public function getDisplayerAttribute(): FieldDisplayerContract
    {
        $class = \FieldDisplayer::getDisplayer($this->attributes['displayer']);
        return new $class($this);
    }

    /**
     * Get Field display handler
     * 
     * @return FieldDisplay
     */
    public function getFieldDisplay(): FieldDisplay
    {
        return \FieldDisplay::getFieldDisplay($this->object);
    }

    /**
     * Field getter
     * 
     * @return FieldContract
     */
    public function getField(): FieldContract
    {
        return $this->getFieldDisplay()->getField($this->field);
    }

    /**
     * View mode relationship
     * 
     * @return BelongsTo
     */
    public function view_mode()
    {
        return $this->belongsTo(ViewMode::class);
    }

    public function getRenderer(Entity $entity, ViewMode $viewMode)
    {
        return new EntityFieldRenderer($entity, $viewMode, $this);
    }
}