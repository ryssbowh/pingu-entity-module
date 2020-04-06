<?php

namespace Pingu\Entity\Traits\Controllers\Display;

use Pingu\Entity\Entities\DisplayField;
use Pingu\Field\Support\FieldDisplayer;

trait EditsFieldDisplayOptions
{
    public function edit($displayer)
    {
        $values = $this->request->input('values', []);
        $fieldDisplay = DisplayField::findOrfail($this->requireParameter('display'));
        $displayerClass = \FieldDisplayer::getDisplayer($displayer);
        $displayer = new $displayerClass($fieldDisplay);
        $displayer->setOptions($values);
        $action = ['url' => route('entity.ajax.validateFieldDisplayOptions', $displayer::machineName())];
        $form = $displayer->options()->getEditForm($action);
        return $this->onFieldLayoutOptionsSuccess($form);
    }
}
