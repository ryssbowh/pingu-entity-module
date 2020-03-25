<?php

namespace Pingu\Entity\Entities\Validators;

use Pingu\Field\Support\FieldValidator\BaseFieldsValidator;

class ViewModeValidator extends BaseFieldsValidator
{
    /**
     * @inheritDoc
     */
    protected function rules(bool $updating): array
    {
        return [
            'name' => 'required,unique:view_modes,name'
        ];
    }

    /**
     * @inheritDoc
     */
    protected function messages(): array
    {
        return [
        ];
    }
}