<?php

namespace Pingu\Entity\Http\Controllers;

use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Traits\Controllers\Entities\CreatesAdminEntity;
use Pingu\Entity\Traits\Controllers\Entities\DeletesAdminEntity;
use Pingu\Entity\Traits\Controllers\Entities\EditsAdminEntity;
use Pingu\Entity\Traits\Controllers\Entities\IndexesAdminEntity;
use Pingu\Entity\Traits\Controllers\Entities\PatchesAdminEntity;
use Pingu\Entity\Traits\Controllers\Entities\StoresAdminEntity;
use Pingu\Entity\Traits\Controllers\Entities\UpdatesAdminEntity;

class AdminEntityController extends BaseController
{	
	use EditsAdminEntity, 
		UpdatesAdminEntity, 
		CreatesAdminEntity, 
		StoresAdminEntity, 
		DeletesAdminEntity, 
		PatchesAdminEntity, 
		IndexesAdminEntity;
}

?>