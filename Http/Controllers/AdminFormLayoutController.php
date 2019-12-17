<?php 

namespace Pingu\Entity\Http\Controllers;

use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Contracts\BundleContract;

class AdminFormLayoutController extends BaseController
{
    public function indexBundle(BundleContract $bundle)
    {
        \ContextualLinks::addFromObject($bundle);
        return \Response::view(
            'entity::indexFormLayout', 
            [
                'fields' => $bundle->fields()->getAll(),
                'layout' => $bundle->formLayout(),
                'bundle' => $bundle,
                'canCreateGroups' => \Gate::check('createGroups', $bundle)
            ], 
            200, 
            ['Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0']
        );
    }
}