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
            'formLayout' => [
                'label' => 'Form layout',
                'url' => function ($bundle) {
                    return $bundle::uris()->make('formLayout', $bundle, adminPrefix());
                },
                'access' => function ($bundle) {
                    return \Gate::check('formLayout', $bundle);
                }
            ],
            'display' => [
                'label' => 'Display',
                'url' => function ($bundle) {
                    return $bundle::uris()->make('display', $bundle, adminPrefix());
                },
                'access' => function ($bundle) {
                    return \Gate::check('display', $bundle);
                }
            ]
        ];
    }
}