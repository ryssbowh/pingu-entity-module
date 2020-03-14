<?php

namespace Pingu\Entity\Support;

use Pingu\Entity\Contracts\EntityFormRepositoryContract;
use Pingu\Entity\Forms\BaseEntityEditRevisionForm;
use Pingu\Entity\Forms\BaseEntityFilterForm;
use Pingu\Forms\Support\BaseForms;
use Pingu\Forms\Support\Form;

class BaseEntityForms extends BaseForms implements EntityFormRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function editRevision(array $args): Form
    {
        return new BaseEntityEditRevisionForm(...$args);
    }

    /**
     * @inheritDoc
     */
    public function filter(array $fields, array $action): Form
    {
        return new BaseEntityFilterForm($this->model, $fields, $action);
    }
}