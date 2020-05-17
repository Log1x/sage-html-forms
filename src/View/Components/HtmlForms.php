<?php

namespace Log1x\HtmlForms\View\Components;

use Illuminate\Support\Str;
use Roots\Acorn\View\Component;

class HtmlForms extends Component
{
    /**
     * The current form.
     *
     * @var string
     */
    public $form;

    /**
     * The hidden view slot.
     *
     * @return string
     */
    public $hidden;

    /**
     * Create the component instance.
     *
     * @param  string $title
     * @param  string $subtitle
     * @param  string $background
     * @param  string $color
     * @return void
     */
    public function __construct(
        $form,
        $messages = [],
        $hidden = null
    ) {
        $this->form = hf_get_form($form);
        $this->hidden = $hidden;

        $this->form->attributes = collect($this->form->messages)->merge(
            collect($messages)->keyBy(function ($value, $key) {
                return Str::snake($key);
            })
        )->keyBy(function ($value, $key) {
            return Str::finish('data-message-', Str::slug($key));
        })->merge([
            'method' => 'post',
            'class' => Str::finish('hf-form hf-form-', $this->form->ID),
            'data-id' => (string) $this->form->ID,
            'data-title' => $this->form->title,
            'data-slug' => $this->form->slug,
        ])->sortKeys()->all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return $this->view('HtmlForms::components.html-forms');
    }
}
