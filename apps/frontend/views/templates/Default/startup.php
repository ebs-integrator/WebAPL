<?php

Core\APL\Template::setColorSchemes(array(
    
    'blue' => array(
        'name' => 'Blue',
        'css' => res('assets/css/styles/blue.css' ,'frontend')
    ),
    'greenbrown' => array(
        'name' => 'Green brown',
        'css' => res('assets/css/styles/green_brown.css' ,'frontend')
    ),
    'pink' => array(
        'name' => 'Pink',
        'css' => res('assets/css/styles/pink.css' ,'frontend')
    ),
    'yellow' => array(
        'name' => 'Yellow',
        'css' => res('assets/css/styles/yellow.css' ,'frontend')
    ),
    'blue-green' => array(
        'name' => 'Blue Green',
        'css' => res('assets/css/styles/blue_green.css' ,'frontend')
    )
    
));

Config::set('template.logo', true);
Config::set('template.logo_multilang', true);
Config::set('template.logo_small', true);

Event::listen('firechat_top', function () {
    echo HTML::style(res('assets/css/firechat.css'));
});