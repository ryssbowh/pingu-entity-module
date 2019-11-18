<?php

namespace Pingu\Entity\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModuleMakeEntityActions extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument name.
     *
     * @var string
     */
    protected $argumentName = 'name';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-entity-actions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new actions class for the specified module.';

    public function getDefaultNamespace() : string
    {
        return $this->laravel['modules']->config('paths.generator.entity-action.path', 'Entities/Actions');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the entity the actions class is for.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        Stub::setBasePath(__DIR__ . '/stubs');

        $class = $entity = $this->getClass();
        $class .= 'Actions';

        return (new Stub("/entity-actions.stub", [
            'NAMESPACE'    => $this->getClassNamespace($module),
            'CLASS'        => $class
        ]))->render();
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $entityPath = GenerateConfigReader::read('entity-actions');

        return $path . $entityPath->getPath() . '/' . $this->getFileName() . '.php';
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return Str::studly($this->argument('name')) . 'Actions';
    }

    /**
     * Get class namespace.
     *
     * @param \Nwidart\Modules\Module $module
     *
     * @return string
     */
    public function getEntityNamespace($namespace, $entity)
    {
        $elems = explode('\\', $namespace);
        unset($elems[sizeof($elems) - 1]);

        return implode('\\', $elems) . '\\' . $entity;
    }
}