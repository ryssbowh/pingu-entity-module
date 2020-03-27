<?php

namespace Pingu\Entity\Traits\Controllers\Layout;

use Illuminate\Http\Request;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Entities\FormLayout;
use Pingu\Forms\Support\Form;

trait EditsFieldLayoutOptions
{
    public function edit(string $field)
    {
        $class = \FormField::getRegisteredOptions($field);
        $values = $this->requireParameter('values');
        $options = new $class($values);
        $action = ['url' => route('entity.ajax.validateFieldLayoutOptions', $field)];
        $form = $options->getEditForm($action);
        return $this->onFormLayoutOptionsSuccess($form);
    }
}
