<?php

namespace Pingu\Entity\Http\Controllers;

use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Traits\Controllers\Bundles\CreatesAjaxBundleFields;
use Pingu\Entity\Traits\Controllers\Bundles\DeletesAjaxBundleFields;
use Pingu\Entity\Traits\Controllers\Bundles\EditsAjaxBundleFields;
use Pingu\Entity\Traits\Controllers\Bundles\PatchesAjaxBundleFields;
use Pingu\Entity\Traits\Controllers\Bundles\StoresAjaxBundleFields;
use Pingu\Entity\Traits\Controllers\Bundles\UpdatesAjaxBundleFields;

class AjaxBundleController extends BaseController
{   
    use CreatesAjaxBundleFields,
        StoresAjaxBundleFields,
        UpdatesAjaxBundleFields,
        EditsAjaxBundleFields,
        DeletesAjaxBundleFields,
        PatchesAjaxBundleFields;
}

?>