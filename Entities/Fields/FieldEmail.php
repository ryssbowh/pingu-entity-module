<?php

namespace Pingu\Entity\Entities\Fields;

use Pingu\Core\Entities\BaseModel;
use Pingu\Entity\Contracts\BundleFieldContract;
use Pingu\Entity\Traits\BundleField;
use Pingu\Forms\Support\Fields\Checkbox;
use Pingu\Forms\Support\Fields\Email;
use Pingu\Forms\Support\Fields\TextInput;
use Pingu\Forms\Support\Types\Boolean;
use Pingu\Forms\Support\Types\Text;
use Pingu\Forms\Traits\Models\Formable;

class FieldEmail extends BaseModel implements BundleFieldContract
{
	use BundleField, Formable;

    protected $fillable = ['default', 'required'];

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
        return ['name', 'helper', 'default', 'required'];
    }

    /**
     * @inheritDoc
     */
    public function formEditFields()
    {
        return ['name', 'helper', 'default', 'required'];
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
                'field' => TextInput::class
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
            'default' => 'email',
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
            'title.required' => 'Title is required'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function friendlyName(): string
    {
    	return 'Email';
    }

    /**
     * @inheritDoc
     */
    public function bundleFieldDefinition()
    {
        return [
            'field' => TextInput::class,
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
        return ($this->required ? 'required|' : '') . 'email';
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
        return 'email';
    }
}
