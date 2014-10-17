<?php

\Core\APL\Template::setColorSchemes(array(
    
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
    )
    
));

Event::listen('firechat_top', function () {
    echo HTML::style(res('assets/css/firechat.css'));
});