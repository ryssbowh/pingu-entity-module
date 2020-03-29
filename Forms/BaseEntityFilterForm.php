<?php
namespace Pingu\Entity\Forms;

use Pingu\Entity\Support\Entity;
use Pingu\Forms\Support\Fields\Link;
use Pingu\Forms\Support\Fields\Submit;
use Pingu\Forms\Support\Form;

class BaseEntityFilterForm extends Form
{
   
    /**
     * @var Entity
     */
    protected $entity;

    /**
     * @var array
     */
    protected $action;

    /**
     * @inheritDoc
     */
    public function __construct(Entity $entity, array $fields, array $action)
    {
        $this->entity = $entity;
        $this->action = $action;
        $this->fields = $fields;
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function elements(): array
    {
        $fields = $this->entity->fields()->get($this->fields)->map(function ($field) {
            $field = $field->toFilterFormElement();
            $field->option('showLabel', false);
            $field->option('placeholder', $field->option('label'));
            return $field;
        })->all();
        $fields[] = new Submit(
            '_submit', 
            [
                'label' => 'Filter'
            ]
        );
        $fields[] = new Link(
            '_reset', 
            [
                'label' => 'Reset',
                'url' => $this->action['url']
            ]
        );
        return $fields;
    }

    /**
     * @inheritDoc
     */
    public function method(): string
    {
        return 'GET';
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
        return 'filter-'.$this->entity->identifier();
    }

    /**
     * @inheritDoc
     */
    protected function afterBuilt()
    {
        $this->classes->add(['form-filter', 'form-filter-entity', 'form-filter'.$this->name()]);
    }
}