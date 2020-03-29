<?php

namespace Pingu\Entity\Support\Actions;

use Pingu\Core\Support\Actions;
use Pingu\Entity\Support\Entity;
use Pingu\Field\Contracts\HasRevisionsContract;

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
                'url' => function (Entity $entity) {
                    return $entity::uris()->make('edit', $entity, adminPrefix());
                },
                'access' => function (Entity $entity) {
                    return \Gate::check('edit', $entity);
                }
            ],
            'delete' => [
                'label' => 'Delete',
                'url' => function (Entity $entity) {
                    return $entity::uris()->make('confirmDelete', $entity, adminPrefix());
                },
                'access' => function (Entity $entity) {
                    return \Gate::check('delete', $entity);
                }
            ],
            'revisions' => [
                'label' => 'Revisions',
                'url' => function (Entity $entity) {
                    return $entity::uris()->make('indexRevisions', $entity, adminPrefix());
                },
                'access' => function (Entity $entity) {
                    return ($entity instanceof HasRevisionsContract and \Gate::check('viewRevisions', $entity));
                }
            ]
        ];
    }
}
