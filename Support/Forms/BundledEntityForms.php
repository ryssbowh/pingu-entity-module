<?php

namespace Pingu\Entity\Support\Forms;

use Pingu\Entity\Forms\BundledEntityCreateForm;
use Pingu\Entity\Forms\BundledEntityEditForm;
use Pingu\Forms\Support\Form;

class BundledEntityForms extends BaseEntityForms
{
    /**
     * @inheritDoc
     */
    public function create(array $args): Form
    {
        return new BundledEntityCreateForm(...$args);
    }

    /**
     * @inheritDoc
     */
    public function edit(array $args): Form
    {
        return new BundledEntityEditForm(...$args);
    }
}