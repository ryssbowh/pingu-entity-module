<?php

namespace Pingu\Entity\Http\Controllers;

use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Traits\Controllers\Entities\CreatesAjaxEntity;
use Pingu\Entity\Traits\Controllers\Entities\DeletesAjaxEntity;
use Pingu\Entity\Traits\Controllers\Entities\EditsAjaxEntity;
use Pingu\Entity\Traits\Controllers\Entities\IndexesAjaxEntity;
use Pingu\Entity\Traits\Controllers\Entities\PatchesAjaxEntity;
use Pingu\Entity\Traits\Controllers\Entities\StoresAjaxEntity;
use Pingu\Entity\Traits\Controllers\Entities\UpdatesAjaxEntity;

class WebEntityController extends BaseController
{   
    use CreatesAjaxEntity, 
        StoresAjaxEntity, 
        EditsAjaxEntity, 
        UpdatesAjaxEntity, 
        DeletesAjaxEntity, 
        PatchesAjaxEntity, 
        IndexesAjaxEntity;
}

?>