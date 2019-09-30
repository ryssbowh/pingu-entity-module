<?php

namespace Pingu\Entity\Entities;

use Pingu\Core\Entities\BaseModel;

class BundleFieldValue extends BaseModel
{
    protected $fillable = ['value', 'revision_id'];

    protected $casts = [
        'value' => 'json'
    ];

    protected $visible = ['value'];

    /**
     * Field relation
     * 
     * @return Relation
     */
    public function field()
    {
    	return $this->belongsTo(BundleField::class);
    }

    public function entity()
    {
        return $this->morphTo();
    }

    public function getValueAttribute($value)
    {
        return $this->field->instance->retrieveValue(json_decode($value));
    }
}
