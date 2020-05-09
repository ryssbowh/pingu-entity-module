<?php

namespace Pingu\Entity\Support\FieldRepository;

use Illuminate\Support\Collection;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\BundledEntity;
use Pingu\Field\Support\FieldRepository\BaseFieldRepository;

/**
 * Defines a Field repository for a bundled entity
 */
abstract class BundledEntityFieldRepository extends BaseFieldRepository
{
    /**
     * @inheritDoc
     */
    public function __construct(BundledEntity $object)
    {
        $this->object = $object;
    }

    /**
     * Get the bundle associated to the entity
     *
     * @throws FieldRepositoryException
     * 
     * @return ?BundleContract
     */
    protected function getBundle(): ?BundleContract
    {
        return $this->object->bundle();
    }

    /**
     * Returns all bundle fields
     * 
     * @return Collection
     */
    protected function getBundleFields(): Collection
    {
        if ($this->getBundle()) {
            return $this->getBundle()->fieldRepository()->all();
        }
        return collect();
    }

    /**
     * @inheritDoc
     */
    protected function buildFields(): Collection
    {
        return parent::buildFields()->merge($this->getBundleFields());
    }
}