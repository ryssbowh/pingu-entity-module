<?php

namespace Pingu\Entity\Support\FieldDisplay;

use Illuminate\Support\Collection;
use Pingu\Entity\Contracts\BundleContract;

class FieldDisplayBundle extends FieldDisplay
{
    /**
     * @ingeritDoc
     */
    public function __construct(BundleContract $object)
    {
        parent::__construct($object);
    }
    
    /**
     * @ingeritDoc
     */
    protected function getFields(): Collection
    {
        return $this->object->fieldRepository()->getAll();
    }
}