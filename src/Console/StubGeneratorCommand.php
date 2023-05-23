<?php

namespace MDerakhshi\LaravelStubGenerator\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class StubGeneratorCommand extends Command
{

    protected $name = 'stub-generate';

    protected $description = 'generate from stubs';

    protected array $ignoreFiles = ['.gitkeep'];

    public function handle()
    {
        /*        // $optimizeType = $this->option('type');
                $sourceDirectory = base_path('stubs/' . $this->argument('type'));
                if (file_exists($sourceDirectory) && is_dir($sourceDirectory)) {
                    $directoryName   = (is_null($this->argument('parent'))) ? $this->argument('name') : $this->argument('parent');
                    $targetDirectory = base_path(Str::plural($this->argument('type')) . '/' . ucfirst($directoryName));
                    (new StubGeneratorClass())->handle([
                        'sourceDirectory' => $sourceDirectory,
                        'targetDirectory' => $targetDirectory,
                        'name'            => $this->argument('name'),
                    ]);
                } else {
                    $this->error($sourceDirectory . ' is not exist !');
                }*/
    }

    protected function getArguments(): array
    {
        return [
            ['type', InputArgument::REQUIRED, 'The type of the generate.'],
            ['name', InputArgument::REQUIRED, 'The name of the action.'],
            ['parent', InputArgument::OPTIONAL, 'The name of the parent .'],
        ];
    }

}