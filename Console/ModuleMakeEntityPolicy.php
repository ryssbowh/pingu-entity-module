<?php

namespace Pingu\Entity\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModuleMakeEntityPolicy extends GeneratorCommand
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
    protected $name = 'module:make-entity-policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new entity policy class for the specified module.';

    public function getDefaultNamespace() : string
    {
        return $this->laravel['modules']->config('paths.generator.entity-policy.path', 'Entities/Policies');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the entity the policy is for.'],
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
        $class .= 'Policy';
        
        $namespace = $this->getClassNamespace($module);

        return (new Stub(
            "/entity-policy.stub", [
            'NAMESPACE'    => $this->getClassNamespace($module),
            'CLASS'        => $class,
            'ENTITY'       => $entity,
            'ENTITY_CLASS' => $this->getEntityNamespace($namespace, $entity)
            ]
        ))->render();
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $entityPath = GenerateConfigReader::read('entity-policy');

        return $path . $entityPath->getPath() . '/' . $this->getFileName() . '.php';
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return Str::studly($this->argument('name')) . 'Policy';
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