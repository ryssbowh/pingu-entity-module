<?php

namespace Pingu\Entity\Support\FieldLayout;

use Illuminate\Support\Collection;
use Pingu\Entity\Contracts\BundleContract;

class FieldLayoutBundle extends FieldLayout
{
    /**
     * Constructor
     * 
     * @param HasFieldsContract $object
     */
    public function __construct(BundleContract $object)
    {
        parent::__construct($object);
    }

    /**
     * @return Collection
     */
    protected function getFields(): Collection
    {
        return $this->object->fields()->getAll();
    }
}