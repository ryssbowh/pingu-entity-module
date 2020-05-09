<?php

namespace Pingu\Entity\Http\Contexts;

use Illuminate\Support\Collection;
use Pingu\Core\Contracts\RouteContexts\RouteContextContract;
use Pingu\Core\Support\Contexts\BaseRouteContext;
use Pingu\Field\Contracts\BundleFieldContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Forms\BundleFieldsForm;
use Pingu\Forms\Support\Form;

class CreateBundleFieldContext extends BaseRouteContext implements RouteContextContract
{
    protected $field;

    public static function scope(): string
    {
        return 'createField';
    }

    /**
     * Get bundle field from route
     * 
     * @return BundleField
     */
    protected function getField(): BundleFieldContract
    {
        if (is_null($this->field)) {
            $type = $this->requireParameter('_field');
            $field = \Field::getRegisteredBundleField($type);
            $this->field = new $field;
        }
        return $this->field;
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
        return ['url' => $this->object->uris()->make('storeField', $this->object, $this->getRouteScope())];
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
            'fieldType' => $this->getField(),
            'bundle' => $this->object
        ];
        
        return view()->first($this->getViewNames(), $with);
    }

    /**
     * View names for editing a field
     *
     * @return array
     */
    protected function getViewNames()
    {
        return ['pages.bundles.'.$this->object->name().'.createField', 'pages.bundles.createField'];
    }

    /**
     * Create the edit form
     * 
     * @return Form
     */
    protected function getForm(): Form
    {   
        return $this->getField()->forms()->create([$this->getField(), $this->getFields(), $this->getFormAction()]);
    }
}