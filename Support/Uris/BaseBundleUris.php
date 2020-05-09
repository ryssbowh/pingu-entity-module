<?php

namespace Pingu\Entity\Support\Uris;

use Pingu\Core\Support\Uris\Uris;
use Pingu\Field\Entities\BundleField;

class BaseBundleUris extends Uris
{
    /**
     * @inheritDoc
     */
    protected function replacableSlugs(): array
    {
        return [
            '@slug@' => BundleField::routeSlug()
        ];
    }
    
    /**
     * @inheritDoc
     */
    protected function uris(): array
    {
        return [
            'indexFields' => 'bundle/{bundle}/fields',
            'editField' => 'bundle/{bundle}/fields/{@slug@}/edit',
            'storeField' => 'bundle/{bundle}/fields',
            'patchFields' => 'bundle/{bundle}/fields',
            'createField' => 'bundle/{bundle}/fields/create',
            'updateField' => 'bundle/{bundle}/fields/{@slug@}',
            'confirmDeleteField' => 'bundle/{bundle}/fields/{@slug@}/delete',
            'deleteField' => 'bundle/{bundle}/fields/{@slug@}/delete',
            'fieldLayout' => 'bundle/{bundle}/layout',
            'fieldDisplay' => 'bundle/{bundle}/display',
            'patchFieldLayout' => 'bundle/{bundle}/layout',
            'patchFieldDisplay' => 'bundle/{bundle}/display',
        ];
    }
}