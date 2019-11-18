<?php

namespace Pingu\Entity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntityRequest extends FormRequest
{
    protected $bundle;

    public function getBundle()
    {
        if (!$this->bundle) {
            $this->bundle = \Bundle::get($this->route()->parameters()['bundle']);
        }
        return $this->bundle;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        foreach($this->getBundle()->entityBundleFields() as $field){
            $rules[$field->machineName] = $field->instance->bundleFieldValidationRule();
        }
        return $rules;
    }

    public function messages()
    {
        $messages = [];
        foreach($this->getBundle()->entityBundleFields() as $field){
            foreach($field->instance->bundleFieldValidationMessages() as $name => $message){
                $messages[$field->machineName.'.'.$name] = $message;
            }
        }
        return $messages;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getBundle()->authorizeEntityCreation();
    }
}
