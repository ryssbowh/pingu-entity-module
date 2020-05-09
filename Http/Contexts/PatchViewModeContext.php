<?php

namespace Pingu\Entity\Http\Contexts;

use Illuminate\Support\Collection;
use Pingu\Core\Http\Contexts\PatchContext;
use Pingu\Entity\Entities\ViewModesMapping;

class PatchViewModeContext extends PatchContext
{   
    /**
     * @inheritDoc
     */
    public static function scope(): string
    {
        return 'ajax.patch';
    }

    /**
     * @inheritDoc
     */
    public function performPatch(array $data): Collection
    {
        $mapping = \ViewMode::getMapping();
        $patched = collect();
        foreach ($mapping as $viewMode => $objects) {
            $viewModeModel = \ViewMode::get($viewMode);
            $toDelete = array_diff($objects, $data[$viewMode] ?? []);
            $toAdd = array_diff($data[$viewMode] ?? [], $objects);
            foreach ($toDelete as $object) {
                ViewModesMapping::where('view_mode_id', $viewModeModel->id)->where('object', $object)->first()->delete();
            }
            foreach ($toAdd as $object) {
                $map = new ViewModesMapping;
                $map->fill([
                    'object' => $object
                ])->view_mode()->associate($viewModeModel)->save();
                $patched->push($viewModeModel);
            }
        }
        return $patched;
    }
}