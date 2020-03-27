<?php

namespace Pingu\Entity\Traits\Controllers\Layout;

use Illuminate\Http\Request;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\FormLayout;
use Pingu\Entity\Entities\FormLayoutGroup;

trait PatchesFieldLayout
{
    protected function findOrCreateGroup(array $data)
    {
        if (isset($data['id'])) {
            $group = FormLayoutGroup::findOrFail($data['id']);
            $group->weight = $data['weight'] ?? null;
        } else {
            $group = new FormLayoutGroup;
            $validated = $group->validator()->validateValues($data);
            $group->fill($validated);
        }
        $group->save();
        return $group;
    }

    public function patch(Request $request, BundleContract $bundle)
    {
        $groups = $request->post('groups', []);
        $groupIds = [];
        foreach ($groups as $id => $data) {
            $data['object'] = $bundle->bundleName();
            $group = $this->findOrCreateGroup($data);
            $groupIds[] = $group->id;
            foreach ($data['models'] ?? [] as $data) {
                $field = \FormField::getRegisteredField($data['widget']);
                $options = \FormField::getRegisteredOptions($field);
                $options = (new $options)->castValues(json_decode($data['options'], true));
                $layout = FormLayout::findOrFail($data['id']);
                $layout->fill([
                    'weight' => $data['weight'],
                    'options' => $options,
                    'widget' => $data['widget']
                ])->group()->associate($group)->save();
            }
            
        }
        $toDelete = FormLayoutGroup::where('object', $bundle->bundleName())->whereNotIn('id', $groupIds)->get();
        foreach ($toDelete as $group) {
            $group->delete();
        }
        return $this->onPatchFormLayoutSuccess($bundle);
    }
}
