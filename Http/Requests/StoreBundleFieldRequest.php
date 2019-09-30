<?php

namespace Pingu\Entity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Pingu\Core\Exceptions\ParameterMissing;
use Pingu\Entity\Entities\BundleField;
use Pingu\Entity\Exceptions\RouteActionNotSet;

class StoreBundleFieldRequest extends FormRequest
{
    public function getField()
    {
        $field = $this->post('_field', false);
        if(!$field){
            throw new ParameterMissing('_field', 'post');
        }
        $field = \BundleField::getRegisteredBundleField($field);
        return new $field;
    }

    protected function getBundle()
    {
        $actions = $this->route()->action;
        if(!isset($actions['bundle'])){
            throw new RouteActionNotSet($this, 'bundle');
        }
        return $actions['bundle'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $generic = new BundleField;

        $rules = $generic->getStoreValidationRules();
        $rules = array_merge($rules, $this->getField()->getStoreValidationRules());

        return $rules;
    }

    public function messages()
    {
        $generic = new BundleField;
        
        $messages = $generic->getValidationMessages();
        $messages = array_merge($messages, $this->getField()->getValidationMessages());

        return $messages;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $bundle = $this->getBundle();
        $validator->after(function ($validator) use ($bundle) {
            $machineName = $validator->getData()['machineName'];
            $listFields = $bundle->bundleFields()->pluck('machineName')->toArray();
            if(in_array($machineName, $listFields)){
                $validator->errors()->add('machineName', 'This machine name already exists for this bundle');
            }
        });
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
