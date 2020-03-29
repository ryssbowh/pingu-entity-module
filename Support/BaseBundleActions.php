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
                },
                'access' => function ($bundle) {
                    return \Gate::check('indexFields', $bundle);
                }
            ],
            'fieldLayout' => [
                'label' => 'Form layout',
                'url' => function ($bundle) {
                    return $bundle::uris()->make('fieldLayout', $bundle, adminPrefix());
                },
                'access' => function ($bundle) {
                    return \Gate::check('fieldLayout', $bundle);
                }
            ],
            'fieldDisplay' => [
                'label' => 'Display',
                'url' => function ($bundle) {
                    return $bundle::uris()->make('fieldDisplay', [$bundle, 'default'], adminPrefix());
                },
                'access' => function ($bundle) {
                    return \Gate::check('fieldDisplay', $bundle);
                }
            ]
        ];
    }
}