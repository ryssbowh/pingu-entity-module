<?php

namespace Pingu\Entity\Support;

use Pingu\Core\Support\Actions;

/**
 * Defines actions for a bundle
 */
class BaseBundleActions extends Actions
{
    /**
     * @inheritDoc
     */
    protected function actions(): array
    {
        return [
            'indexFields' => [
                'label' => 'Manage fields',
                'url' => function ($bundle) {
                    return $bundle::uris()->make('indexFields', $bundle, adminPrefix());
                }
            ]
        ];
    }
}