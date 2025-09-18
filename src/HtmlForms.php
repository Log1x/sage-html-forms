<?php

namespace Log1x\HtmlForms;

use Illuminate\Support\Str;

use function Roots\view;

class HtmlForms
{
    /**
     * Create a new HtmlForms instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->render();

        if (is_admin()) {
            $this->cleanAdmin();
        }
    }

    /**
     * Render forms using Blade if a corresponding view exists.
     *
     * @param  string  $html
     * @param  \HTML_Forms\Form  $form
     * @return string
     */
    protected function render()
    {
        add_filter('hf_form_html', function ($html, $form) {
            if (! view()->exists('forms.'.$form->slug)) {
                return $html;
            }

            return view(
                Str::start($form->slug, 'forms.'),
                ['form' => $form->ID]
            )->render();
        }, 5, 2);
    }

    /**
     * Clean up the HTML Forms admin page and move the menu item to
     * the Options submenu.
     *
     * @return void
     */
    protected function cleanAdmin()
    {
        add_filter('hf_admin_output_misc_settings', function () {
            echo '<style>.hf-sidebar { display: none; }</style>';
        });

        if (apply_filters('hf_hide_admin_menu', true)) {
            add_filter('admin_menu', function () {
                remove_menu_page('html-forms');
                add_submenu_page(
                    'options-general.php',
                    'HTML Forms',
                    'HTML Forms',
                    'edit_forms',
                    'html-forms'
                );
            });
        }
    }
}
