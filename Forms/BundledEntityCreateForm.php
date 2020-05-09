<?php

namespace Pingu\Entity\Forms;

use Pingu\Core\Forms\BaseModelCreateForm;

class BundledEntityCreateForm extends BaseModelCreateForm
{
    /**
     * @inheritDoc
     */
    public function groups(): array
    {
        dump($this->model->fieldLayout()->toFormGroups());
        return $this->model->fieldLayout()->toFormGroups();
    }
}