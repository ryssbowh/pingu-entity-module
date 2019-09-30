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

class AdminBundleController extends BaseController
{
	use IndexesAdminBundleFields, 
		CreatesAdminBundleFields,
		StoresAdminBundleFields,
		UpdatesAdminBundleFields,
		EditsAdminBundleFields,
		DeletesAdminBundleFields,
		PatchesAdminBundleFields;
}