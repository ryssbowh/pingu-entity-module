<?php

namespace Pingu\Entity\Forms;

use Pingu\Forms\Forms\BaseModelCreateForm;

class BundledEntityCreateForm extends BaseModelCreateForm
{
    /**
     * @inheritDoc
     */
    public function groups(): array
    {
        return $this->model->fieldLayout()->toFormGroups();
    }
}