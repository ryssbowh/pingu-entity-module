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
            'indexFields' => 'bundle/{bundle}/fields',
            'editField' => 'bundle/{bundle}/fields/{'.BundleField::routeSlug().'}/edit',
            'storeField' => 'bundle/{bundle}/fields',
            'patchFields' => 'bundle/{bundle}/fields',
            'createField' => 'bundle/{bundle}/fields/create',
            'updateField' => 'bundle/{bundle}/fields/'.'{'.BundleField::routeSlug().'}',
            'confirmDeleteField' => 'bundle/{bundle}/fields/'.'{'.BundleField::routeSlug().'}/delete',
            'deleteField' => 'bundle/{bundle}/fields/'.'{'.BundleField::routeSlug().'}/delete',
            'formLayout' => 'bundle/{bundle}/form-layout',
            'display' => 'bundle/{bundle}/display',
            'patchFormLayout' => 'bundle/{bundle}/form-layout',
            'patchDisplay' => 'bundle/{bundle}/display',
        ];
    }
}