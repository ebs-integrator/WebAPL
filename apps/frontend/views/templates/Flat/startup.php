<?php

Core\APL\Template::setColorSchemes(array(
));

class TemplateViews {

    public static function mapPage($data) {
        $data['page']->text = \Core\APL\Shortcodes::execute($data['page']->text);
        $data['tree'] = Post::treePosts(0, array(
                    'general_node' => 1
        ));
        
        return View::make('sections.pages.sitemap')->with($data);
    }

}

// Replace current pageView
Core\APL\Template::registerViewMethod('page', 'mapPage', null, array('TemplateViews', 'mapPage'), true);
