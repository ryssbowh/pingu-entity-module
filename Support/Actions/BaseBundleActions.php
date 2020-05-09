<?php

namespace Pingu\Entity\Support\Actions;

use Pingu\Core\Support\Actions\BaseAction;
use Pingu\Core\Support\Actions\BaseActionRepository;

/**
 * Defines actions for a bundle
 */
class BaseBundleActions extends BaseActionRepository
{
    /**
     * @inheritDoc
     */
    protected function actions(): array
    {
        return [
            'indexFields' => new BaseAction(
                'Manage fields',
                function ($bundle) {
                    return $bundle::uris()->make('indexFields', $bundle, adminPrefix());
                },
                function ($bundle) {
                    return \Gate::check('indexFields', $bundle);
                },
                'admin'
            ),
            'fieldLayout' => new BaseAction(
                'Layout',
                function ($bundle) {
                    return $bundle::uris()->make('fieldLayout', $bundle, adminPrefix());
                },
                function ($bundle) {
                    return \Gate::check('fieldLayout', $bundle);
                },
                'admin'
            ),
            'fieldDisplay' => new BaseAction(
                'Display',
                function ($bundle) {
                    return $bundle::uris()->make('fieldDisplay', [$bundle], adminPrefix());
                },
                function ($bundle) {
                    return \Gate::check('fieldDisplay', $bundle);
                },
                'admin'
            )
        ];
    }
}