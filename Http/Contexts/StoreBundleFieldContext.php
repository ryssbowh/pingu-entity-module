<?php

namespace Pingu\Entity\Http\Contexts;

use Illuminate\Support\Collection;
use Pingu\Core\Contracts\RouteContexts\ValidatableContextContract;
use Pingu\Core\Support\Contexts\BaseRouteContext;
use Pingu\Field\Contracts\BundleFieldContract;
use Pingu\Field\Contracts\HasFieldsContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Forms\BundleFieldsForm;
use Pingu\Field\Support\FieldValidator;
use Pingu\Forms\Support\Form;

class StoreBundleFieldContext extends BaseRouteContext implements ValidatableContextContract
{
    protected $field;

    public static function scope(): string
    {
        return 'storeField';
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
        try{
            $validated = $this->validateRequest();
            $this->performStore($validated);
        }
        catch(\Exception $e){
            return $this->onFailure($e);
        }

        if ($this->wantsJson()) {
            return $this->jsonResponse();
        }
        $this->notify();
        return $this->redirect();
    }

    /**
     * Notify the user
     */
    protected function notify()
    {
        \Notify::success($this->getField()::friendlyName().' field '.$this->getField()->name.' has been saved');
    }

    /**
     * Redirects the user after success
     * 
     * @return RedirectResponse
     */
    protected function redirect()
    {
        return redirect($this->object->uris()->make('indexFields', [$this->object], $this->getRouteScope()));
    }

    /**
     * Json response
     * 
     * @return array
     */
    protected function jsonResponse(): array
    {
        return ['model' => $this->getField(), 'message' => 'Field '.$this->getField()->name." has been created"];
    }

    /**
     * Perform store
     * 
     * @param BundleFieldContract $field
     * @param array               $fieldValidated
     * @param array               $genericValidated
     * @param BundleContract      $bundle
     * 
     * @return BundleFieldContract
     */
    protected function performStore(array $validated): BundleField
    {
        if ($fixedCardinality = $this->getField()->fixedCardinality() !== false) {
            $validated['cardinality'] = $fixedCardinality;
        }
        return BundleField::create($validated, $this->object, $this->getField());
    }

    /**
     * Validates a request and return validated array
     * 
     * @return array
     */
    protected function validateRequest(): array
    {
        return FieldValidator::forContext($this->getField(), $this)->validateRequest($this->request);
    }

    /**
     * @inheritDoc
     */
    public function getValidationRules(HasFieldsContract $object): array
    {
        return $object->fieldRepository()->validationRules()->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getValidationMessages(HasFieldsContract $object): array
    {
        return $object->fieldRepository()->validationMessages()->toArray();
    }

    /**
     * Behaviour when store fails
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