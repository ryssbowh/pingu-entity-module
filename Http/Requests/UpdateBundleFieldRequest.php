<?php

namespace Pingu\Entity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Pingu\Entity\Entities\BundleField;
use Pingu\Entity\Exceptions\BundleFieldException;

class UpdateBundleFieldRequest extends FormRequest
{
    public function getField()
    {
        $parameters = $this->route()->parameters();
        if(!isset($parameters[BundleField::routeSlug()])){
            throw BundleFieldException::slugNotSetInRoute();
        }
        return $parameters[BundleField::routeSlug()];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getField()->instance->getUpdateValidationRules();
    }

    public function messages()
    {
        return $this->getField()->instance->getValidationMessages();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getField()->editable;
    }
}
