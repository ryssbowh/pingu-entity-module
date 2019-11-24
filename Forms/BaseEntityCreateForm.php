<?php

namespace Pingu\Entity\Forms;

use Illuminate\Support\Str;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\Entity;
use Pingu\Forms\Support\Fields\Submit;
use Pingu\Forms\Support\Form;

class BaseEntityCreateForm extends Form
{
    protected $action;
    protected $entity;
    protected $bundle;

    /**
     * Bring variables in your form through the constructor :
     */
    public function __construct(Entity $entity, array $action, ?BundleContract $bundle)
    {
        $this->action = $action;
        $this->entity = $entity;
        $this->bundle = $bundle;
        parent::__construct();
    }

    /**
     * Fields definitions for this form, classes used here
     * must extend Pingu\Forms\Support\Field
     * 
     * @return array
     */
    public function elements(): array
    {
        $fields = $this->entity->fields()->toFormElements();
        if ($this->bundle) {
            $fields = array_merge($fields, $this->bundle->fields()->toFormElements());
        }
        $fields['_submit'] = new Submit('_submit');
        return $fields;
    }

    /**
     * Method for this form, POST GET DELETE PATCH and PUT are valid
     * 
     * @return string
     */
    public function method(): string
    {
        return 'POST';
    }

    /**
     * Url for this form, valid values are
     * ['url' => '/foo.bar']
     * ['route' => 'login']
     * ['action' => 'MyController@action']
     * 
     * @return array
     * 
     * @see https://github.com/LaravelCollective/docs/blob/5.6/html.md
     */
    public function action(): array
    {
        return $this->action;
    }

    /**
     * Name for this form, ideally it would be application unique, 
     * best to prefix it with the name of the module it's for.
     * only alphanumeric and hyphens
     * 
     * @return string
     */
    public function name(): string
    {
        return 'create-'.class_machine_name($this->entity);
    }
}