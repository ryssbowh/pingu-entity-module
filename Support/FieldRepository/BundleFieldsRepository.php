<?php

namespace Pingu\Entity\Support\FieldRepository;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Support\FieldRepository\BaseFieldRepository;

/**
 * Defines a list of fields for a bundle
 */
class BundleFieldsRepository extends BaseFieldRepository
{
    /**
     * @inheritDoc
     */
    public function __construct(BundleContract $object)
    {
        $this->object = $object;
    }

    /**
     * Returns bundle fields, including the entity base fields
     * 
     * @return Collection
     */
    public function getAll(): Collection
    {
        $entity = $this->object->entityFor();
        $entity = new $entity;
        $entity->setBundle($this->object);
        return $entity->fieldRepository()->all();
    }

    /**
     * Delete all bundle fields
     */
    public function deleteAll()
    {
        foreach ($this->get() as $field) {
            $field->field->delete(true);
        }
    }

    /**
     * @inheritDoc
     */
    protected function fields(): array
    {
        if (!Schema::hasTable('bundle_fields')) {
            return collect();
        }

        $fields = [];
        $bundleFields = BundleField::where(['bundle' => $this->object->identifier()])->get();
        foreach ($bundleFields as $field) {
            $fields[] = $field->instance;
        }
        return $fields;
    }

    /**
     * @inheritDoc
     */
    protected function rules(): array
    {
        $out = [];
        foreach ($this->all() as $field) {
            $rules = $field->defaultValidationRules();
            $out = array_merge($out, $rules);
        }
        return $out;
    }

    /**
     * @inheritDoc
     */
    protected function messages(): array
    {
        $out = [];
        foreach ($this->all() as $field) {
            $messages = $field->defaultValidationMessages();
            $out = array_merge($out, $messages);
        }
        return $out;
    }
}