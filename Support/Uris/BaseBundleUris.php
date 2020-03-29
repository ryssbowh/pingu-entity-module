<?php

namespace Pingu\Entity\Support\Uris;

use Pingu\Core\Support\Uris;
use Pingu\Field\Entities\BundleField;

class BaseBundleUris extends Uris
{
    /**
     * @inheritDoc
     */
    public function uris(): array
    {
        return [
            'indexFields' => 'bundle/{bundle}/fields',
            'editField' => 'bundle/{bundle}/fields/{'.BundleField::routeSlug().'}/edit',
            'storeField' => 'bundle/{bundle}/fields',
            'patchFields' => 'bundle/{bundle}/fields',
            'createField' => 'bundle/{bundle}/fields/create',
            'updateField' => 'bundle/{bundle}/fields/'.'{'.BundleField::routeSlug().'}',
            'confirmDeleteField' => 'bundle/{bundle}/fields/'.'{'.BundleField::routeSlug().'}/delete',
            'deleteField' => 'bundle/{bundle}/fields/'.'{'.BundleField::routeSlug().'}/delete',
            'fieldLayout' => 'bundle/{bundle}/layout',
            'fieldDisplay' => 'bundle/{bundle}/display/{view_mode}',
            'patchFieldLayout' => 'bundle/{bundle}/layout',
            'patchFieldDisplay' => 'bundle/{bundle}/display/{view_mode}',
        ];
    }
}