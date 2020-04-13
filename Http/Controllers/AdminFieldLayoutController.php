<?php 

namespace Pingu\Entity\Http\Controllers;

use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\RendersAdminViews;
use Pingu\Entity\Contracts\BundleContract;

class AdminFieldLayoutController extends BaseController
{
    use RendersAdminViews;

    public function index(BundleContract $bundle)
    {
        \ContextualLinks::addFromObject($bundle);
        $with = [
            'fields' => $bundle->fields()->getAll(),
            'layout' => \FieldLayout::getFieldLayout($bundle),
            'bundle' => $bundle,
            'canCreateGroups' => \Gate::check('createGroups', $bundle)
        ];
        return $this->renderAdminView(
            $this->getViewNames($bundle),
            'entity-layout',
            $with
        );
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
        return ['pages.bundles.'.$bundle->name().'.fieldLayout.index', 'pages.bundles.fieldLayout.index'];
    }
}