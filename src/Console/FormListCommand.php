<?php

namespace Log1x\HtmlForms\Console;

use Roots\Acorn\Console\Commands\Command;
use Illuminate\Support\Str;

class FormListCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'form:list {name?}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List the available forms and submissions managed by HTML Forms';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! empty($this->argument('name'))) {
            $form = collect(
                get_posts([
                    'post_type' => 'html-form',
                    'name' => $this->argument('name'),
                    'post_status' => 'publish',
                    'posts_per_page' => 1,
                    'ignore_sticky_posts' => true,
                    'no_found_rows' => true,
                ])
            );

            if ($form->isEmpty()) {
                return $this->error(
                    sprintf('The form %s could not be found.', $this->argument('name'))
                );
            }

            $submissions = collect(
                hf_get_form_submissions($form->shift()->ID)
            )->filter();

            if ($submissions->isEmpty()) {
                return $this->line('There were no submissions found for the %s form.', $form->shift()->title);
            }

            return $this->table(
                collect($submissions->first()->data)->keys()->map(function ($value) {
                    return Str::title(str_replace('_', ' ', $value));
                })->all(),
                $submissions->map(function ($value) {
                    return array_values($value->data);
                })->all()
            );
        }

        return $this->table(['ID', 'Name', 'Slug', 'Actions', 'Submissions'], collect(
            get_posts(['post_type' => 'html-form'])
        )->map(function ($value) {
            $value = hf_get_form($value->ID);

            return [
                $value->ID,
                $value->title,
                $value->slug,
                collect($value->settings['actions'])->map(function ($value) {
                    return Str::title($value['type']);
                })->implode(', '),
                collect(
                    hf_get_form_submissions($value->ID)
                )->count(),
            ];
        })->all());
    }
}
