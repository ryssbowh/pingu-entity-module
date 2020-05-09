<?php

namespace Pingu\Entity\Forms;

use Pingu\Core\Forms\BaseModelEditForm;

class BundledEntityEditForm extends BaseModelEditForm
{
    /**
     * @inheritDoc
     */
    public function groups(): array
    {
        return $this->model->fieldLayout()->toFormGroups();
    }
}