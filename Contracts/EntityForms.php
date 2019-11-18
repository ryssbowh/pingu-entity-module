<?php

namespace Pingu\Entity\Contracts;

use Pingu\Entity\Entities\Entity;
use Pingu\Forms\Support\Form;

abstract class EntityForms
{
    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Get create form
     * 
     * @param array  $args
     * 
     * @return Form
     */
    abstract public function create(array $args): Form;

    /**
     * Get edit form
     *
     * @param array  $args
     * 
     * @return Form
     */
    abstract public function edit(array $args): Form;

    /**
     * Get delete form
     * 
     * @param array  $args
     * 
     * @return Form
     */
    abstract public function delete(array $args): Form;
}