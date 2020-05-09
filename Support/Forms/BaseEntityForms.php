<?php

namespace Pingu\Entity\Support\Forms;

use Pingu\Entity\Forms\BaseEntityEditRevisionForm;
use Pingu\Entity\Forms\BaseEntityFilterForm;
use Pingu\Forms\Support\BaseForms;
use Pingu\Forms\Support\Form;

class BaseEntityForms extends BaseForms
{
    /**
     * @inheritDoc
     */
    public function editRevision(array $args): Form
    {
        return new BaseEntityEditRevisionForm(...$args);
    }
}