<?php 

namespace Pingu\Entity\Http\Controllers;

use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\ViewMode;

class AdminFieldDisplayController extends BaseController
{
    /**
     * Index action
     * 
     * @param BundleContract $bundle
     * @param ViewMode       $display
     * 
     * @return View
     */
    public function index(BundleContract $bundle, ViewMode $viewMode)
    {
        \ContextualLinks::addFromObject($bundle);
        return view()->first($this->getViewNames($bundle), [
            'display' => $bundle->fieldDisplay(),
            'bundle' => $bundle,
            'canCreateGroups' => \Gate::check('createGroups', $bundle),
            'viewMode' => $viewMode
        ]);
    }

    /**
     * Get index layout view names
     * 
     * @param BundleContract $bundle
     * 
     * @return array
     */
    protected function getViewNames(BundleContract $bundle)
    {
        return ['pages.bundles.'.$bundle->name().'.fieldDisplay.index', 'pages.bundles.fieldDisplay.index'];
    }
}