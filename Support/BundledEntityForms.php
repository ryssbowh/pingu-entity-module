<?php

namespace Pingu\Entity\Support;

use Pingu\Entity\Forms\BundledEntityCreateForm;
use Pingu\Entity\Forms\BundledEntityEditForm;
use Pingu\Forms\Support\BaseForms;
use Pingu\Forms\Support\Form;

class BundledEntityForms extends BaseForms
{
    /**
     * @inheritDoc
     */
    public function create(array $args): Form
    {
        return new BundledEntityCreateForm($this->model, ...$args);
    }

    /**
     * @inheritDoc
     */
    public function edit(array $args): Form
    {
        return new BundledEntityEditForm($this->model, ...$args);
    }
}