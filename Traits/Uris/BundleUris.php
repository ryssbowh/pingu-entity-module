<?php

namespace Pingu\Entity\Traits\Uris;

use Pingu\Entity\Entities\BundleField;

trait BundleUris
{
    public function indexFields(): string
    {
        return 'bundles/'.$this->object->bundleName().'/fields';
    }

    public function editField(): string
    {
        return 'bundles/'.$this->object->bundleName().'/fields/{'.BundleField::routeSlug().'}/edit';
    }

    public function storeField(): string
    {
        return 'bundles/'.$this->object->bundleName().'/fields';
    }

    public function patchFields(): string
    {
        return 'bundles/'.$this->object->bundleName().'/fields';
    }

    public function createField(): string
    {
        return 'bundles/'.$this->object->bundleName().'/fields/create';
    }

    public function updateField(): string
    {
        return 'bundles/'.$this->object->bundleName().'/fields/'.'{'.BundleField::routeSlug().'}';
    }

    public function confirmDeleteField(): string
    {
        return 'bundles/'.$this->object->bundleName().'/fields/'.'{'.BundleField::routeSlug().'}/delete';
    }

    public function deleteField(): string
    {
        return 'bundles/'.$this->object->bundleName().'/fields/'.'{'.BundleField::routeSlug().'}/delete';
    }
}