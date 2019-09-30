<?php

namespace Pingu\Entity\Entities;

use Pingu\Content\Events\ContentFieldCreated;
use Pingu\Content\Events\DeletingContentField;
use Pingu\Core\Contracts\Models\HasCrudUrisContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\Models\HasBasicCrudUris;
use Pingu\Core\Traits\Models\HasWeight;
use Pingu\Entity\Contracts\EntityContract;
use Pingu\Forms\Contracts\Models\FormableContract;
use Pingu\Forms\Support\Fields\NumberInput;
use Pingu\Forms\Support\Fields\TextInput;
use Pingu\Forms\Traits\Models\Formable;

class BundleField extends BaseModel implements FormableContract, HasCrudUrisContract
{
    use Formable, HasBasicCrudUris, HasWeight;

    protected $fillable = ['weight', 'machineName', 'bundle'];

    protected $attributes = [
        'editable' => true,
        'deletable' => true
    ];

    protected $with = [];

    public static function boot()
    {
        parent::boot();

        static::saving(function($field){
            if(is_null($field->weight)){
                $field->weight = $field::getNextWeight(['bundle' => $field->bundle]);
            }
        });
    }

    public static function routeSlug()
    {
        return 'bundle_field';
    }

    /**
     * @inheritDoc
     */
    public function formAddFields()
    {
        return ['machineName'];
    }

    /**
     * @inheritDoc
     */
    public function formEditFields()
    {
        return ['weight'];
    }

    /**
     * @inheritDoc
     */
    public function fieldDefinitions()
    {
        return [
            'weight' => [
                'field' => NumberInput::class
            ],
            'machineName' => [
                'field' => TextInput::class,
                'options' => [
                    'helper' => 'Unique machine name, cannot be edited'
                ],
                'attributes' => [
                    'class' => 'js-dashify',
                    'data-dashifyfrom' => 'name',
                    'required' => true
                ]
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationRules()
    {
        return [
            'machineName' => 'required|string',
            'weight' => 'integer'
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationMessages()
    {
        return [
            'machineName.required' => 'Machine name is required'
        ];
    }

    public function bundleFieldDefinition()
    {
        return array_replace_recursive([
            'options' => [
            ]
        ], $this->instance->bundleFieldDefinition());
    }

    /**
     * Morph this field into its instance
     * 
     * @return Relation
     */
    public function instance()
    {
        return $this->morphTo();
    }

    public function values()
    {
        return $this->hasMany(BundleFieldValue::class, 'field_id')->orderBy('revision_id', 'desc');
    }

    public function valueModel(EntityContract $entity)
    {
        return $this->values->where('entity_id', $entity->id)->where('entity_type', get_class($entity))->first();
    }

    public function value(EntityContract $entity)
    {
        $value = $this->valueModel($entity);
        if($value) return $value->value;
        return null;
    }

    public function bundle()
    {
        return \Entity::getRegisteredBundle($this->bundle);
    }

    public function getLastRevision(EntityContract $entity)
    {
        if(!$value = $this->valueModel($entity)) return 0;
        return $value->revision_id;
    }

    public function buildBundleFieldClass(): Field
    {
        $definition = $this->instance->bundleFieldDefinition();
        return new $definition['field']($name, $definition['options'] ?? [], $definition['attributes'] ?? []);
    }

}
