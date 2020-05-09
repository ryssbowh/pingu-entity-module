<?php

namespace Pingu\Entity\Entities\Fields;

use Pingu\Field\BaseFields\Text;
use Pingu\Field\Support\FieldRepository\BaseFieldRepository;

class FormLayoutGroupFields extends BaseFieldRepository
{
    protected function fields(): array
    {
        return [
            new Text('name'),
            new Text('object')
        ];
    }

    protected function rules(): array
    {
        return [
            'name' => 'string|required',
            'object' => 'string|required',
        ];
    }

    protected function messages(): array
    {
        return [

        ];
    }

    protected function modifyValidator(Validator $validator, array $values, bool $updating)
    {
        $validator->after(
            function ($validator) {
                $object = $validator->getData()['object'];
                $name = $validator->getData()['name'];
                $group = FormLayoutGroup::where(['name' => $name, 'object' => $object])->first();
                if ($group) {
                    $validator->errors()->add('name', 'This group already exist');
                }
            }
        );
    }
}