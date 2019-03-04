<?php

namespace Fomvasss\LaravelVisualEditable;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishedConfig();

        $this->publishedMigrations();

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/visual-editable'),
        ], 'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/visual-editable.php', 'visual-editable');

        $this->app->singleton(ModelVisualEditor::class, function () {
            return new ModelVisualEditor($this->app);
        });
        $this->app->singleton(BlockVisualEditor::class, function () {
            return new BlockVisualEditor($this->app);
        });
    }

    protected function publishedConfig()
    {
        $this->publishes([
            __DIR__.'/../config/visual-editable.php' => config_path('visual-editable.php')
        ], 'visual-editable-config');
    }

    protected function publishedMigrations()
    {
        if (! class_exists('CreateBlocksTable')) {
            $timestamp = date('Y_m_d_His', time());

            $migrationPath = __DIR__.'/../database/migrations/create_visual_blocks_table.php.stub';
            $this->publishes([$migrationPath => database_path('/migrations/'.$timestamp.'_create_visual_blocks_table.php'),
                ], 'visual-editable-migrations');
        }
    }
}
