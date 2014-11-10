<?php

WebAPL\Template::setColorSchemes(array(
    
    'blue' => array(
        'name' => 'Albastru',
        'css' => res('assets/css/styles/blue.css' ,'frontend')
    ),
    'greenbrown' => array(
        'name' => 'Maro',
        'css' => res('assets/css/styles/green_brown.css' ,'frontend')
    ),
    'pink' => array(
        'name' => 'Roz',
        'css' => res('assets/css/styles/pink.css' ,'frontend')
    ),
    'yellow' => array(
        'name' => 'Cenusiu',
        'css' => res('assets/css/styles/yellow.css' ,'frontend')
    ),
    'blue-green' => array(
        'name' => 'Albastru - verde',
        'css' => res('assets/css/styles/blue_green.css' ,'frontend')
    )
    
));

Config::set('template.logo', true);
Config::set('template.logo_multilang', true);
Config::set('template.logo_small', true);

Config::set('template.page_icon_big', true);
Config::set('template.page_icon', true);
Config::set('template.page_icon_active', true);
Config::set('template.page_bg', true);
Config::set('template.page_bg_all', false);

Event::listen('firechat_top', function () {
    echo HTML::style(res('assets/css/firechat.css'));
});