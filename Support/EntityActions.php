<?php

namespace Pingu\Entity\Support;

use Pingu\Core\Support\Actions;

class EntityActions extends Actions
{
    /**
     * @inheritDoc
     */
    public function actions(): array
    {
        return [
            'edit' => [
                'label' => 'Edit',
                'url' => function ($entity) {
                    return $entity::uris()->make('edit', $entity, adminPrefix());
                },
                'access' => function ($entity) {
                    return \Gate::check('edit', $entity);
                }
            ],
            'delete' => [
                'label' => 'Delete',
                'url' => function ($entity) {
                    return $entity::uris()->make('confirmDelete', $entity, adminPrefix());
                },
                'access' => function ($entity) {
                    return \Gate::check('delete', $entity);
                }
            ]
        ];
    }
}
