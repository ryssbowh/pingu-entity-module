<?php

namespace Pingu\Entity\Traits\Controllers\Layout;

use Illuminate\Http\Request;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Entities\FormLayout;
use Pingu\Field\Entities\FormLayoutGroup;
use Pingu\Forms\Support\Form;

trait PatchesFormLayout
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
                $layout = FormLayout::findOrFail($data['id']);
                $layout->fill([
                    'group_id' => $group->id,
                    'weight' => $data['weight'],
                    'options' => json_decode($data['options']),
                    'widget' => $data['widget']
                ])->save();
            }
            
        }
        $toDelete = FormLayoutGroup::where('object', $bundle->bundleName())->whereNotIn('id', $groupIds)->get();
        foreach ($toDelete as $group) {
            $group->delete();
        }
        return $this->onPatchFormLayoutSuccess($bundle);
    }
}
