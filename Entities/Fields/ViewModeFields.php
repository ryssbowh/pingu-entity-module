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
}