<?php

namespace Pingu\Entity\Support\Actions;

use Pingu\Core\Support\Actions\BaseAction;
use Pingu\Core\Support\Actions\BaseActionRepository;
use Pingu\Entity\Support\Entity;
use Pingu\Field\Contracts\HasRevisionsContract;

class EntityActions extends BaseActionRepository
{
    /**
     * @inheritDoc
     */
    public function actions(): array
    {
        return [
            'edit' => new BaseAction(
                'Edit',
                function (Entity $entity) {
                    return $entity::uris()->make('edit', $entity, adminPrefix());
                },
                function (Entity $entity) {
                    return \Gate::check('edit', $entity);
                }
            ),
            'delete' => new BaseAction(
                'Delete',
                function (Entity $entity) {
                    return $entity::uris()->make('confirmDelete', $entity, adminPrefix());
                },
                function (Entity $entity) {
                    return \Gate::check('delete', $entity);
                }
            )
        ];
    }
}
