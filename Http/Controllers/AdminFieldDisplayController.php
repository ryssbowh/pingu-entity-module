<?php 

namespace Pingu\Entity\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\RendersAdminViews;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\ViewMode;

class AdminFieldDisplayController extends BaseController
{
    use RendersAdminViews;
    
    /**
     * Index action
     * 
     * @param BundleContract $bundle
     * @param ViewMode       $display
     * 
     * @return View
     */
    public function index(Request $request, BundleContract $bundle)
    {
        $viewMode = \ViewMode::getByName($request->input('viewMode', 'default'));
        \ContextualLinks::addFromObject($bundle);
        $with = [
            'display' => $bundle->fieldDisplay()->forViewMode($viewMode),
            'bundle' => $bundle,
            'currentViewMode' => $viewMode,
            'viewModes' => \ViewMode::forObject($bundle)
        ];
        return $this->renderAdminView(
            $this->getViewNames($bundle),
            'entity-display',
            $with
        );
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