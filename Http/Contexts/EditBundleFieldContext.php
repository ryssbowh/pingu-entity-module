<?php

namespace Pingu\Entity\Http\Contexts;

use Illuminate\Support\Collection;
use Pingu\Core\Contracts\RouteContexts\RouteContextContract;
use Pingu\Core\Support\Contexts\BaseRouteContext;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Forms\BundleFieldsForm;
use Pingu\Forms\Support\Form;

class EditBundleFieldContext extends BaseRouteContext implements RouteContextContract
{
    public static function scope(): string
    {
        return 'editField';
    }

    /**
     * Get bundle field from route
     * 
     * @return BundleField
     */
    protected function getField(): BundleField
    {
        return $this->routeParameter(BundleField::routeSlug());
    }

    /**
     * @inheritDoc
     */
    public function getResponse()
    {
        $form = $this->getForm();
        if ($this->wantsJson()) {
            return $this->jsonResponse($form);
        }
        return $this->renderView($form);
    }

    /**
     * Json response
     * 
     * @param Form $form
     * 
     * @return array
     */
    public function jsonResponse(Form $form): array
    {
        return ['html' => $form->render()];
    }

    /**
     * Action for the form
     * 
     * @return array
     */
    protected function getFormAction(): array
    {
        return ['url' => $this->object->uris()->make('updateField', [$this->object, $this->getField()], $this->getRouteScope())];
    }

    /**
     * Get fields available for the form
     * 
     * @return Collection
     */
    protected function getFields(): Collection
    {
        return $this->getField()->fieldRepository()->all();
    }

    /**
     * Get the view for a edit field request
     *
     * @param Form $form
     * 
     * @return view
     */
    protected function renderView(Form $form)
    {
        $with = [
            'form' => $form,
            'field' => $this->getField()
        ];
        
        return view()->first($this->getViewNames($bundle), $with);
    }

    /**
     * View names for editing a field
     *
     * @return array
     */
    protected function getViewNames()
    {
        return ['pages.bundles.'.$this->object->name().'.editField', 'pages.bundles.editField'];
    }

    /**
     * Create the edit form
     * 
     * @return Form
     */
    protected function getForm(): Form
    {   
        return $this->getField()->instance->forms()->edit([$this->getField()->instance, $this->getFields(), $this->getFormAction()]);
    }
}