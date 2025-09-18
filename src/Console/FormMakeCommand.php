<?php

namespace Log1x\HtmlForms\Console;

use Illuminate\Support\Str;
use Roots\Acorn\Console\Commands\GeneratorCommand;

class FormMakeCommand extends GeneratorCommand
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:form {name* : The form slug.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new form view for the HTML Forms plugin.';

    /**
     * The view stub used when generated.
     *
     * @var string|bool
     */
    protected $view = 'default';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->task("Generating {$this->getViewName()}", function () {
            if (! $this->files->exists($this->getViewPath())) {
                $this->files->makeDirectory($this->getViewPath());
            }

            if ($this->files->exists($this->getView())) {
                return;
            }

            $this->files->put($this->getView(), $this->files->get($this->getViewStub()));
        });

        return $this->summary();
    }

    /**
     * Return the full view destination.
     *
     * @return string
     */
    public function getView()
    {
        return Str::finish($this->getViewPath(), $this->getViewName());
    }

    /**
     * Return the view destination filename.
     *
     * @return string
     */
    public function getViewName()
    {
        return Str::finish(
            str_replace('.', '/', Str::slug(Str::snake($this->getNameInput()))),
            '.blade.php'
        );
    }

    /**
     * Return the view destination path.
     *
     * @return string
     */
    public function getViewPath()
    {
        return Str::finish($this->getPaths(), '/forms/');
    }

    /**
     * Get the view stub file for the generator.
     *
     * @return string
     */
    protected function getViewStub()
    {
        return __DIR__."/stubs/views/{$this->view}.stub";
    }

    /**
     * Return the applications view path.
     *
     * @param  string  $name
     * @return void
     */
    protected function getPaths()
    {
        $paths = $this->app['view.finder']->getPaths();

        if (count($paths) === 1) {
            return head($paths);
        }

        return $this->choice('Where do you want to create the view(s)?', $paths, head($paths));
    }

    /**
     * Return the block creation summary.
     *
     * @return void
     */
    protected function summary()
    {
        $this->line('');
        $this->line('<fg=blue;options=bold>Form View Created</>');
        $this->line("    ⮑  <fg=blue>{$this->shortenPath($this->getView(), 4)}</>");
    }

    /**
     * Clear the current line in console output.
     *
     * @return Command
     */
    public function clearLine()
    {
        if (! $this->output->isDecorated()) {
            $this->output->writeln('');

            return $this;
        }

        $this->output->write("\x0D");
        $this->output->write("\x1B[2K");

        return $this;
    }

    /**
     * Run a task in the console.
     *
     * @param  string  $title
     * @param  callable|null  $task
     * @param  string  $status
     * @return mixed
     */
    protected function task($title, $task = null, $status = '...')
    {
        $title = Str::start($title, '<fg=blue;options=bold>➡</> ');

        if (! $task) {
            return $this->output->write("{$title}: <info>✔</info>");
        }

        $this->output->write("{$title}: <comment>{$status}</comment>");

        try {
            $status = $task() !== false;
        } catch (\Exception $e) {
            $this->clearLine()->line("{$title}: <fg=red;options=bold>x</>");

            throw $e;
        }

        $this->clearLine()->line("{$title}: ".($status ? '<info>✔</info>' : '<fg=red;options=bold>x</>'));
    }

    /**
     * Returns a shortened path.
     *
     * @param  string  $path
     * @param  int  $i
     * @return string
     */
    protected function shortenPath($path, $i = 3)
    {
        return collect(
            explode('/', $path)
        )->slice(-$i, $i)->implode('/');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        //
    }
}
