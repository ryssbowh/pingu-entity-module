<?php

namespace Pingu\Entity\Forms;

use Illuminate\Support\Str;
use Pingu\Core\Entities\BaseModel;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\BundledEntity;
use Pingu\Forms\Support\Fields\Submit;
use Pingu\Forms\Support\Form;

class BundledEntityCreateForm extends Form
{
    protected $action;
    protected $entity;

    /**
     * Bring variables in your form through the constructor :
     */
    public function __construct(BundledEntity $entity, array $action)
    {
        $this->action = $action;
        $this->entity = $entity;
        $this->formLayout = $entity->formLayout();
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function elements(): array
    {
        $fields = $this->entity->fields()->toFormElements();
        foreach ($fields as $field) {
            $options = $this->formLayout->getField($field->getName())->options->values();
            $field->mergeOptions($options);
        }
        $fields['_submit'] = new Submit('_submit');
        return $fields;
    }

    /**
     * @inheritDoc
     */
    public function method(): string
    {
        return 'POST';
    }

    /**
     * @inheritDoc
     */
    public function groups(): array
    {
        return $this->formLayout->toFormGroups();
    }

    /**
     * @inheritDoc
     */
    public function action(): array
    {
        return $this->action;
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return 'create-'.class_machine_name($this->entity);
    }
}