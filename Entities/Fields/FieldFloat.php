<?php

namespace Pingu\Entity\Entities\Fields;

use Pingu\Core\Entities\BaseModel;
use Pingu\Entity\Contracts\BundleFieldContract;
use Pingu\Entity\Traits\BundleField;
use Pingu\Forms\Support\Fields\Checkbox;
use Pingu\Forms\Support\Fields\NumberInput;
use Pingu\Forms\Support\Fields\TextInput;
use Pingu\Forms\Support\Types\_Float;
use Pingu\Forms\Traits\Models\Formable;

class FieldFloat extends BaseModel implements BundleFieldContract
{
    use BundleField, Formable;

    protected $fillable = ['precision', 'default', 'required'];

    protected $casts = [
        'required' => 'boolean'
    ];

    protected $attributes = [
        'default' => ''
    ];

    /**
     * @inheritDoc
     */
    public function formAddFields()
    {
        return ['name', 'helper', 'precision', 'default', 'required'];
    }

    /**
     * @inheritDoc
     */
    public function formEditFields()
    {
        return ['name', 'helper', 'precision', 'default', 'required'];
    }

    /**
     * @inheritDoc
     */
    public function fieldDefinitions()
    {
        return [
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
            'default' => [
                'field' => NumberInput::class,
                'options' => [
                    'type' => _Float::class
                ],
                'attributes' => [
                    'step' => 0.000001
                ]
            ],
            'precision' => [
                'field' => NumberInput::class
            ],
            'required' => [
                'field' => Checkbox::class
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationRules()
    {
        return [
            'precision' => 'integer|min:0',
            'default' => 'numeric',
            'required' => 'boolean',
            'name' => 'required|string',
            'helper' => 'string',
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationMessages()
    {
        return [
            'precision.required' => 'Precision is required'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function friendlyName(): string
    {
    	return 'Float';
    }

    /**
     * @inheritDoc
     */
    public function bundleFieldDefinition()
    {
        return [
            'field' => NumberInput::class,
            'options' => [
                'default' => $this->default
            ],
            'attributes' => [
                'required' => $this->required
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function bundleFieldValidationRule()
    {
        return ($this->required ? 'required|' : '') . 'numeric';
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
        return 'float';
    }
}
