<?php 

namespace Pingu\Entity\Http\Controllers;

use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Contracts\BundleContract;

class AdminDisplayController extends BaseController
{
    public function index(BundleContract $bundle)
    {
        \ContextualLinks::addFromObject($bundle);
        return view()->first($this->getViewNames($bundle), [
            'fields' => $bundle->fields()->getAll(),
            'display' => \FieldDisplay::getBundleDisplay($bundle),
            'bundle' => $bundle,
            'canCreateGroups' => \Gate::check('createGroups', $bundle)
        ]);
    }

    /**
     * get index layout view names
     * 
     * @param BundleContract $bundle
     * 
     * @return array
     */
    protected function getViewNames(BundleContract $bundle)
    {
        return ['pages.bundles.'.$bundle->bundleName().'.display.index', 'pages.bundles.display.index'];
    }
}