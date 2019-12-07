<?php

namespace Pingu\Entity\Support;

use Pingu\Entity\Forms\BaseEntityCreateForm;
use Pingu\Entity\Forms\BaseEntityEditRevisionForm;
use Pingu\Forms\Support\BaseForms;
use Pingu\Forms\Support\Form;

class BaseEntityForms extends BaseForms
{
    public function editRevision(array $args): Form
    {
        return new BaseEntityEditRevisionForm( ...$args);
    }
}