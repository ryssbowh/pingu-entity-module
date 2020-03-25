<?php

namespace Pingu\Entity\Traits\Controllers\Display;

use Illuminate\Http\Request;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Entities\FormLayout;
use Pingu\Forms\Support\Form;

trait EditsDisplayOptions
{
    public function edit(string $displayerName)
    {
        $displayer = \FieldDisplay::getRegisteredDisplayer($displayerName);
        $values = $this->requireParameter('values');
        $displayer = new $displayer($values);
        $action = ['url' => route('entity.ajax.validateDisplayOptions', $displayerName)];
        $form = $displayer->options()->getEditForm($action);
        return $this->onFormLayoutOptionsSuccess($form);
    }
}
