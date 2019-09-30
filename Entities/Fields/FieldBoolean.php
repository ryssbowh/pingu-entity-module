<?php

namespace Pingu\Entity\Entities\Fields;

use Pingu\Core\Entities\BaseModel;
use Pingu\Entity\Contracts\BundleFieldContract;
use Pingu\Entity\Traits\BundleField;
use Pingu\Forms\Support\Fields\Checkbox;
use Pingu\Forms\Support\Fields\TextInput;
use Pingu\Forms\Traits\Models\Formable;

class FieldBoolean extends BaseModel implements BundleFieldContract
{
	use BundleField, Formable;

    protected $fillable = ['default'];

    protected $casts = [
    	'default' => 'boolean'
	];

    protected $attributes = [
        'default' => false
    ];

    /**
     * @inheritDoc
     */
    public function retrieveValue($value)
    {
        return (bool)$value;
    }

    public function storeValue($value)
    {
        return (bool)$value;
    }

    /**
     * @inheritDoc
     */
    public function formAddFields()
    {
        return ['name', 'helper', 'default'];
    }

    /**
     * @inheritDoc
     */
    public function formEditFields()
    {
        return ['name', 'helper', 'default'];
    }

    /**
     * @inheritDoc
     */
    public function fieldDefinitions()
    {
        return [
            'default' => [
                'field' => Checkbox::class
            ],
            'name' => [
                'field' => TextInput::class,
                'attributes' => [
                    'required' => true
                ]
            ],
            'helper' => [
                'field' => TextInput::class,
                'options' => [
                    'helper' => 'Describe this field to the user'
                ]
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationRules()
    {
        return [
            'default' => 'boolean',
            'name' => 'required|string',
            'helper' => 'string',
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationMessages()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public static function friendlyName(): string
    {
    	return 'Boolean';
    }
    
    /**
     * @inheritDoc
     */
    public function bundleFieldDefinition()
    {
        return [
            'field' => Checkbox::class,
            'options' => [
                'default' => $this->default
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function bundleFieldValidationRule()
    {
        return 'boolean';
    }

    /**
     * @inheritDoc
     */
    public function bundleFieldValidationMessages()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public static function getMachineName()
    {
        return 'boolean';
    }
}
