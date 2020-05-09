<?php

namespace Pingu\Entity\Entities\Fields;

use Pingu\Field\BaseFields\Text;
use Pingu\Field\Support\FieldRepository\BaseFieldRepository;

class ViewModeFields extends BaseFieldRepository
{
    /**
     * @inheritDoc
     */
    protected function fields(): array
    {
        return [
            new Text(
                'name',
                [
                    'required' => true
                ]
            ),
            new Text(
                'machineName',
                [
                    'required' => true,
                    'dashifyFrom' => 'name'
                ]
            )
        ];
    }

    /**
     * @inheritDoc
     */
    protected function rules(): array
    {
        return [
            'name' => 'required',
            'machineName'=> 'required|unique:view_modes,machineName'
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