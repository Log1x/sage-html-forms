<?php

namespace Log1x\HtmlForms;

use Roots\Acorn\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Log1x\HtmlForms\HtmlForms;
use Log1x\HtmlForms\View\Components\HtmlForms as HtmlFormsComponent;

class HtmlFormsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Log1x\HtmlForms', function () {
            return new HtmlForms();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'HtmlForms');

        $this->callAfterResolving(BladeCompiler::class, function ($view) {
            $view->component(HtmlFormsComponent::class);
        });

        $this->app->make('Log1x\HtmlForms');
    }
}
