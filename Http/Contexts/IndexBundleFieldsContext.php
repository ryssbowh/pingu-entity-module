<?php

namespace Pingu\Entity\Http\Contexts;

use Illuminate\Support\Collection;
use Pingu\Core\Contracts\RouteContexts\RouteContextContract;
use Pingu\Core\Support\Contexts\BaseRouteContext;
use Pingu\Field\Forms\BundleFieldsForm;

class IndexBundleFieldsContext extends BaseRouteContext implements RouteContextContract
{
    public static function scope(): string
    {
        return 'indexFields';
    }

    public function getResponse()
    {
        $fields = $this->object->fieldRepository()->all();

        if ($this->wantsJson()) {
            return $this->jsonResponse($fields);
        }
        return $this->renderView($fields);
    }

    /**
     * Json response
     * 
     * @param Collection $fields
     * 
     * @return array
     */
    public function jsonResponse(Collection $fields): array
    {
        return ['fields' => $fields->toArray()];
    }

    /**
     * Get the view for a index fields request
     * 
     * @param Collection     $fields
     * 
     * @return view
     */
    protected function renderView(Collection $fields)
    {
        $url = ['url' => \Uris::get('bundle')->make('createField', $this->object, adminPrefix())];

        $canCreate = \Gate::check('createFields', $this->object);
        $canEdit = \Gate::check('editFields', $this->object);

        $with = [
            'fields' => $fields,
            'bundle' => $this->object,
            'form' => new BundleFieldsForm($url),
            'canCreate' => $canCreate,
            'canEdit' => $canEdit,
        ];

        return view()->first($this->getIndexFieldViewName(), $with);
    }

    /**
     * View name for creating models
     * 
     * @return string
     */
    protected function getIndexFieldViewName()
    {
        return ['pages.bundles.'.$this->object->name().'.indexFields', 'pages.bundles.indexFields'];
    }
}