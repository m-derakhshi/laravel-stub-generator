<?php

namespace MDerakhshi\LaravelStubGenerator;

use Illuminate\Support\ServiceProvider;
use MDerakhshi\LaravelStubGenerator\Console\StubGeneratorCommand;
use MDerakhshi\LaravelStubGenerator\Http\Controllers\StubGeneratorController;

class StubGeneratorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/stubGenerator.php', 'stubGenerator');
    }

    public function boot(): void
    {
        $this->commands([
            StubGeneratorCommand::class,
        ]);
        $this->app['router']->match(['get', 'post'], 'stub-generator/{sourceType?}', [StubGeneratorController::class, 'index']);
    }

}