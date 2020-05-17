<?php

namespace Log1x\HtmlForms;

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
        $this->clean();
    }

    /**
     * Render forms using Blade if a corresponding view exists.
     *
     * @param  string $html
     * @param  \HTML_Forms\Form $form
     * @return string
     */
    protected function render()
    {
        add_filter('hf_form_html', function ($html, $form) {
            if (! view()->exists('forms.' . $form->slug)) {
                return $html;
            }

            return view('forms.' . $form->slug, ['form' => $form->ID])->render();
        }, 10, 2);
    }

    /**
     * Clean up the HTML Forms admin page and move the menu item to
     * the Options submenu.
     *
     * @return void
     */
    protected function clean()
    {
        add_filter('hf_admin_output_misc_settings', function () {
            echo '<style>.hf-sidebar { display: none; }</style>';
        });

        add_filter('admin_menu', function () {
            remove_menu_page('html-forms');

            array_push($GLOBALS['submenu']['options-general.php'], [
                'HTML Forms',
                'edit_forms',
                admin_url('admin.php?page=html-forms'),
            ]);
        });
    }
}
