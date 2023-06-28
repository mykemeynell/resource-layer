<?php

namespace ResourceLayer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;


final class MakeResourceCommand extends Command
{
    /**
     * Filesystem instance
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:resource {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new resource';

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File: {$path} created");
            return Command::SUCCESS;
        }

        $this->info("File: {$path} already exits");
        return Command::FAILURE;
    }

    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName($name): string
    {
        return ucwords(Pluralizer::singular($name)) . config('resource-layer.resource_suffix', 'Resource');
    }

    /**
     * Return the stub file path
     * @return string
     *
     */
    public function getStubPath(): string
    {
        return __DIR__ . '/../../../stubs/resource.stub';
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getStubVariables(): array
    {
        $baseResource = config('resource-layer.base_resource', \ResourceLayer\Resources\Resource::class);

        return [
            'NAMESPACE'         => 'App\\Resources',
            'CLASS_NAME'        => $this->getSingularClassName(
                $this->argument('name')
            ),
            'BASE_RESOURCE_NAMESPACE' => Str::beforeLast($baseResource, '\\'),
            'BASE_RESOURCE_CLASS_NAME' => class_basename($baseResource)
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return string|array|bool
     */
    public function getSourceFile(): string|array|bool
    {
        return $this->getStubContents(
            $this->getStubPath(), $this->getStubVariables()
        );
    }


    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     *
     * @return array|false|string|string[]
     */
    public function getStubContents($stub, array $stubVariables = []): array|false|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('%'.$search.'%' , $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath(): string
    {
        return base_path('app/Resources') . '/' . $this->getSingularClassName($this->argument('name')) . '.php';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     *
     * @return string
     */
    protected function makeDirectory(string $path): string
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}
