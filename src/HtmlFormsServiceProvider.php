<?php

namespace Log1x\HtmlForms;

use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Support\ServiceProvider;
use Log1x\HtmlForms\HtmlForms;
use Log1x\HtmlForms\Console\FormMakeCommand;
use Log1x\HtmlForms\Console\FormListCommand;
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
        if (! class_exists('\HTML_Forms\Form')) {
            return;
        }

        $this->commands([
            FormMakeCommand::class,
            FormListCommand::class,
        ]);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'HtmlForms');

        $this->callAfterResolving(BladeCompiler::class, function ($view) {
            $view->component(HtmlFormsComponent::class);
        });

        Blade::directive('htmlform', function ($expression) {
            return "<?php echo \hf_get_form($expression); ?>";
        });

        $this->app->make('Log1x\HtmlForms');
    }
}
