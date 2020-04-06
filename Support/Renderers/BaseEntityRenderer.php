<?php 

namespace Pingu\Entity\Support\Renderers;

use Illuminate\Support\Collection;
use Pingu\Core\Support\Renderer;
use Pingu\Core\Support\Renderers\ViewModeRenderer;
use Pingu\Entity\Entities\ViewMode;
use Pingu\Entity\Support\Entity;
use Pingu\Forms\Support\ClassBag;

class BaseEntityRenderer extends ViewModeRenderer
{
    /**
     * Fields to be displayed
     * 
     * @var Collection
     */
    protected $fields;

    public function __construct(Entity $entity, ViewMode $viewMode)
    {
        $this->fields = $this->buildFields($entity, $viewMode);
        parent::__construct($entity, $viewMode);
    }

    /**
     * Fields to be displayed
     * 
     * @return Collecton
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }
    
    /**
     * @inheritDoc
     */
    protected function viewFolder(): string
    {
        return 'entities';
    }

    /**
     * @inheritDoc
     */
    protected function getHookName(): string
    {
        return 'entity';
    }

    /**
     * @inheritDoc
     */
    public function getDefaultData(): Collection
    {
        return collect([
            'entity' => $this->object,
            'classes' => new ClassBag(['entity', $this->viewIdentifier()]),
            'fields' => $this->getFields(),
            'viewMode' => $this->getViewMode()
        ]);
    }

    /**
     * Builds a collection of field renderers
     * 
     * @return Collection
     */
    protected function buildFields(Entity $object, ViewMode $viewMode): Collection
    {
        $fields = [];
        foreach ($object->fieldDisplay()->forViewMode($viewMode) as $display) {
            $fields[] = $display->getRenderer($object, $viewMode);
        }
        return collect($fields);
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultViews(): array
    {
        $folder = $this->viewFolder();
        $id = $this->viewIdentifier();
        $key = $this->viewKey();
        return [
            $folder.'.'.$id.'_'.$this->viewMode->machineName.'_'.$key,
            $folder.'.'.$id.'_'.$key,
            $folder.'.'.$id.'_'.$this->viewMode->machineName,
            $folder.'.'.$id,
            $folder.'.entity',
            $this->object->systemView()
        ];
    }
}