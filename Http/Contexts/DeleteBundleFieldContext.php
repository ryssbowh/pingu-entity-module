<?php

namespace Pingu\Entity\Http\Contexts;

use Illuminate\Support\Collection;
use Pingu\Core\Contracts\RouteContexts\RouteContextContract;
use Pingu\Core\Support\Contexts\BaseRouteContext;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Forms\ConfirmBundleFieldDeletion;

class DeleteBundleFieldContext extends BaseRouteContext implements RouteContextContract
{
    protected $field;

    public static function scope(): string
    {
        return 'deleteField';
    }

    protected function getField()
    {
        if (is_null($this->field)) {
            $this->field = $this->routeParameter(BundleField::routeSlug());
        }
        return $this->field;
    }

    public function getResponse()
    {
        if ($this->request->isMethod('delete')) {
            try {
                $this->performDelete();
            } catch(\Exception $e){
                return $this->onFailure($e);
            }
            return $this->onSuccess();
        }
        return $this->renderView();
    }

    /**
     * Perform the deletion
     */
    protected function performDelete()
    {
        $this->getField()->delete();
    }

    /**
     * Behaviour on deletion success
     * 
     * @return RedirectResponse
     */
    protected function onSuccess()
    {
        if ($this->wantsJson()) {
            return ['model' => $this->getField(), 'message' => 'Field '.$this->getField()->name." has been deleted"];
        }
        \Notify::success('Field '.$this->getField()->name." has been deleted");
        return redirect($this->object->uris()->make('indexFields', [$this->object], $this->getRouteScope()));
    }

    /**
     * Renders a delete confirm form
     * 
     * @return string
     */
    protected function renderView(): string
    {
        $form = $this->getForm($this->getFormAction());
        return view()->first(
            $this->getDeleteFieldViewNames($bundle), [
                'form' => $form,
                'field' => $this->getField()
            ]
        );
    }

    /**
     * View names for deleting models
     * 
     * @return array
     */
    protected function getViewNames(): array
    {
        return ['pages.bundles.'.$this->object->name().'.deleteField', 'pages.bundles.deleteField'];
    }

    /**
     * Action for the form
     * 
     * @return array
     */
    protected function getFormAction(): array
    {
        return ['url' => $this->object->uris()->make('deleteField', [$this->object, $this->getField()], $this->getRouteScope())];
    }

    /**
     * Create the delete form
     * 
     * @param array $action
     * 
     * @return Form
     */
    protected function getForm(array $action): Form
    {   
        return new ConfirmBundleFieldDeletion($this->getField(), $action);
    }

    /**
     * Behaviour when delete fails
     * 
     * @param \Exception $exception
     * 
     * @throws \Exception
     */
    protected function onFailure(\Exception $exception)
    {
        throw $exception;
    }
}