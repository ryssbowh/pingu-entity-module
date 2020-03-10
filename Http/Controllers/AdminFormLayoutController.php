<?php 

namespace Pingu\Entity\Http\Controllers;

use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Contracts\BundleContract;

class AdminFormLayoutController extends BaseController
{
    public function indexBundle(BundleContract $bundle)
    {
        \ContextualLinks::addFromObject($bundle);
        return view()->first($this->getViewNames($bundle), [
            'fields' => $bundle->fields()->getAll(),
            'layout' => \Field::getBundleFormLayout($bundle),
            'bundle' => $bundle,
            'canCreateGroups' => \Gate::check('createGroups', $bundle)
        ])->withHeaders(['Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0']);
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