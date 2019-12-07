<?php 

namespace Pingu\Entity\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModuleMakeEntity extends GeneratorCommand
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
    protected $name = 'module:make-entity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new entity for the specified module.';

    public function getDefaultNamespace() : string
    {
        return $this->laravel['modules']->config('paths.generator.entity.path', 'Entities');
    }

    public function handle()
    {
        parent::handle();
        \Artisan::call(
            'module:make-entity-fields', [
                'module' => $this->argument('module'),
                'name' => $this->argument('name')
            ]
        );
        \Artisan::call(
            'module:make-entity-validator', [
                'module' => $this->argument('module'),
                'name' => $this->argument('name'),
                '--bundled' => $this->option('bundled')
            ]
        );
        \Artisan::call(
            'module:make-entity-policy', [
                'module' => $this->argument('module'),
                'name' => $this->argument('name')
            ]
        );
        \Artisan::call(
            'module:make-entity-routes', [
                'module' => $this->argument('module'),
                'name' => $this->argument('name')
            ]
        );
        \Artisan::call(
            'module:make-entity-uris', [
                'module' => $this->argument('module'),
                'name' => $this->argument('name')
            ]
        );
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the entity.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['bundled', null, InputOption::VALUE_NONE, 'Generates a bundled entity.', null],
        ];
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        $stub = 'entity';
        if ($this->option('bundled')) {
            $stub .= '-bundled';
        }

        Stub::setBasePath(__DIR__ . '/stubs');

        $namespace = $this->getClassNamespace($module);

        return (new Stub(
            "/$stub.stub", [
            'NAMESPACE'    => $namespace,
            'CLASS'        => $this->getClass(),
            'POLICY_CLASS' => $this->getFileName().'Policy',
            'POLICY_NAMESPACE' => $namespace.'\\Policies\\'.$this->getFileName().'Policy'
            ]
        ))->render();
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $entityPath = GenerateConfigReader::read('entity');

        return $path . $entityPath->getPath() . '/' . $this->getFileName() . '.php';
    }

    protected function getPolicyNamespace()
    {

    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return Str::studly($this->argument('name'));
    }
}