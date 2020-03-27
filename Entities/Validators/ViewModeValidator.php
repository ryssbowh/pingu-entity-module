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
        $rules = [
            'name' => 'required'
        ];
        if (!$updating) {
            $rules['machineName'] = 'required|unique:view_modes,machineName';
        }
        return $rules;
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