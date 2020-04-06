<?php

namespace Pingu\Entity\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Support\Entity;

class WebEntityController extends BaseController
{
    public function view(Request $request, Entity $entity)
    {
        return $entity->render();
    }
}

?>