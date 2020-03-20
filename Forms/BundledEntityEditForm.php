<?php

namespace Pingu\Entity\Forms;

use Pingu\Forms\Forms\BaseModelEditForm;

class BundledEntityEditForm extends BaseModelEditForm
{
    /**
     * @inheritDoc
     */
    public function groups(): array
    {
        return $this->model->formLayout()->toFormGroups();
    }
}