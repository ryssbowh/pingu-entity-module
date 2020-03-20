<?php
namespace Pingu\Entity\Forms;

use Pingu\Entity\Entities\Entity;
use Pingu\Field\Support\BaseField;
use Pingu\Field\Support\FieldRevision;
use Pingu\Forms\Forms\BaseModelEditForm;
use Pingu\Forms\Support\Fields\Submit;

class BaseEntityEditRevisionForm extends BaseModelEditForm
{
   
    /**
     * @var FieldRevision
     */
    protected $revision;

    /**
     * Bring variables in your form through the constructor :
     */
    public function __construct(array $url, Entity $entity, FieldRevision $revision)
    {
        $this->revision = $revision;
        $this->formLayout = $entity->formLayout();
        parent::__construct($entity, $url);
    }

    /**
     * Revision getter
     * 
     * @return FieldRevision
     */
    public function revision(): FieldRevision
    {
        return $this->revision;
    }

    /**
     * Fields definitions for this form, classes used here
     * must extend Pingu\Forms\Support\Field
     * 
     * @return array
     */
    public function elements(): array
    {
        $fields = $this->model->fields()->get();
        $out = [];
        foreach ($fields as $field) {
            if ($field instanceof BaseField) {
                $value = $this->revision->value($field->machineName())[0] ?? null;
            } else {
                $value = $this->revision->value($field->machineName());
            }
            $out[] = $field->toFormElement($this->model)->setValue($value);
        }
        $out[] = new Submit(
            '_submit', 
            [
                'label' => 'Restore'
            ]
        );
        return $out;
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
        return 'edit-entity-revision';
    }

    /**
     * @inheritDoc
     */
    public function groups(): array
    {
        return $this->formLayout->toFormGroups();
    }
}