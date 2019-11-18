<?php

namespace Pingu\Entity\Support;

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
            'indexFields' => 'bundles/{bundle}/fields',
            'editField' => 'bundles/{bundle}/fields/{'.BundleField::routeSlug().'}/edit',
            'storeField' => 'bundles/{bundle}/fields',
            'patchFields' => 'bundles/{bundle}/fields',
            'createField' => 'bundles/{bundle}/fields/create',
            'updateField' => 'bundles/{bundle}/fields/'.'{'.BundleField::routeSlug().'}',
            'confirmDeleteField' => 'bundles/{bundle}/fields/'.'{'.BundleField::routeSlug().'}/delete',
            'deleteField' => 'bundles/{bundle}/fields/'.'{'.BundleField::routeSlug().'}/delete'
        ];
    }
}