<?php

// Set template color schemes
WebAPL\Template::setColorSchemes(array(
    'pink-violet' => array(
        'name' => 'Roz - Violet',
        'css' => res('assets/css/style.pink.violet.css', 'frontend')
    ),
    'brown' => array(
        'name' => 'Maro',
        'css' => res('assets/css/style.brown.css', 'frontend')
    ),
    'red' => array(
        'name' => 'Cafeniu',
        'css' => res('assets/css/style.red.css', 'frontend')
    ),
    'red_brown' => array(
        'name' => 'Roșu - Maro',
        'css' => res('assets/css/style.red.brown.css', 'frontend')
    ),
    'violet_green_yellow' => array(
        'name' => 'Violet',
        'css' => res('assets/css/style.violet.green.yellow.css', 'frontend')
    )
));

Config::set('template.logo', false);
Config::set('template.logo_multilang', false);
Config::set('template.logo_small', false);

Config::set('template.page_icon_big', false);
Config::set('template.page_icon', false);
Config::set('template.page_icon_active', false);
Config::set('template.page_bg', true);
Config::set('template.page_bg_all', true);


if (APP_FOLDER === 'frontend') {

    class TemplateViews {

        public static function mapPage($data) {
            $data['page']->text = \WebAPL\Shortcodes::execute($data['page']->text);
            $data['tree'] = Post::treePosts(0, array(
                        'general_node' => 1
            ));

            return View::make('sections.pages.sitemap')->with($data);
        }

    }

    // Replace current pageView
    WebAPL\Template::registerViewMethod('page', 'mapPage', null, array('TemplateViews', 'mapPage'), true);



    Event::listen('APL.modules.afterload', function () {

        // Set custom views for module
        if (class_exists('WebAPL\Modules\Person')) {
            WebAPL\Modules\Person::$view_group_with_persons = 'sections.persons.person_groups';
            WebAPL\Modules\Person::$view_persons_with_photo = 'sections.persons.person_photos';
            WebAPL\Modules\Person::$view_persons_big = 'sections.persons.person_mayors';
            WebAPL\Modules\Person::$view_persons_mayor = 'sections.persons.person_mayor';
            WebAPL\Modules\Person::$view_persons_secretar = 'sections.persons.person_secretar';
            WebAPL\Modules\Person::$view_city_councilors = 'sections.persons.person_councilors';
        }

        if (class_exists('WebAPL\Modules\Newsletter')) {
            WebAPL\Modules\Newsletter::$view_widget = 'sections.newsletter.subscribe';
            WebAPL\Modules\Newsletter::$view_unsub = 'sections.newsletter.unsubscribe';
        }
    });

    Event::listen('firechat_top', function () {
        echo HTML::style(res('assets/css/firechat.css'));
    });
}