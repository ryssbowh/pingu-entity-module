<?php 

namespace Pingu\Entity\Http\Controllers;

use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Contracts\BundleContract;

class AdminFieldLayoutController extends BaseController
{
    public function index(BundleContract $bundle)
    {
        \ContextualLinks::addFromObject($bundle);
        return view()->first($this->getViewNames($bundle), [
            'fields' => $bundle->fields()->getAll(),
            'layout' => \FieldLayout::getBundleFormLayout($bundle),
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
        return ['pages.bundles.'.$bundle->bundleName().'.formLayout.index', 'pages.bundles.formLayout.index'];
    }
}