<?php

namespace Pingu\Entity\Http\Controllers;

use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Traits\Controllers\Bundles\CreatesAdminBundleFields;
use Pingu\Entity\Traits\Controllers\Bundles\DeletesAdminBundleFields;
use Pingu\Entity\Traits\Controllers\Bundles\EditsAdminBundleFields;
use Pingu\Entity\Traits\Controllers\Bundles\IndexesAdminBundleFields;
use Pingu\Entity\Traits\Controllers\Bundles\PatchesAdminBundleFields;
use Pingu\Entity\Traits\Controllers\Bundles\StoresAdminBundleFields;
use Pingu\Entity\Traits\Controllers\Bundles\UpdatesAdminBundleFields;

class AdminBundlesController extends BaseController
{
    public function index()
    {
        $bundles = [];
        foreach (\Bundle::all() as $bundle) {
            $bundles[class_basename($bundle)][] = $bundle;
        }
        return view('entity::bundles')->with(
            [
            'bundles' => $bundles
            ]
        );
    }
}