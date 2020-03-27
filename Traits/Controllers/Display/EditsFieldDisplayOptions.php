<?php

namespace Pingu\Entity\Traits\Controllers\Display;

use Illuminate\Http\Request;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Entities\FormLayout;
use Pingu\Field\Support\FieldDisplayer;
use Pingu\Forms\Support\Form;

trait EditsFieldDisplayOptions
{
    public function edit(FieldDisplayer $displayer)
    {
        $values = $this->requireParameter('values');
        $displayer->setOptions($values);
        $action = ['url' => route('entity.ajax.validateFieldDisplayOptions', $displayer::machineName())];
        $form = $displayer->options()->getEditForm($action);
        return $this->onFormLayoutOptionsSuccess($form);
    }
}
