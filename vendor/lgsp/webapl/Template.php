<?php 
 
 /**
  * 
  * CMS Platform WebAPL 1.0 is a free open source software for creating and managing
  * a web site for Local Public Administration institutions. The platform was
  * developed at the initiative and on a concept of USAID Local Government Support
  * Project in Moldova (LGSP) by the Enterprise Business Solutions Srl (www.ebs.md).
  * The opinions expressed on the website belong to their authors and do not
  * necessarily reflect the views of the United States Agency for International
  * Development (USAID) or the US Government.
  * 
  * This program is free software: you can redistribute it and/or modify it under
  * the terms of the GNU General Public License as published by the Free Software
  * Foundation, either version 3 of the License, or any later version.
  * This program is distributed in the hope that it will be useful, but WITHOUT ANY
  * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
  * PARTICULAR PURPOSE. See the GNU General Public License for more details.
  * 
  * You should have received a copy of the GNU General Public License along with
  * this program. If not, you can read the copy of GNU General Public License in
  * English here: <http://www.gnu.org/licenses/>.
  * 
  * For more details about CMS WebAPL 1.0 please contact Enterprise Business
  * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
  * email to office@ebs.md 
  * 
  **/
 



namespace WebAPL;

use View;

class Template {

    protected static $template;
    protected static $defaultTemplate = 'Dafault';
    protected static $module = null;
    protected static $view_mods = array(
        'page' => array(
            'posturi_vacante' => array(
                'name' => 'Listă de posturi vacante',
                'function' => array('PageView', 'posturiVacante'),
                'support_item' => true,
                'screen' => '/upload/help/posturi_vacante.png',
                'info' => 'Necesita feed cu cimpurile: Data'
            ),
            'promisiuni_primar_page' => array(
                'name' => 'Pagina bloc',
                'function' => array('PageView', 'promisesPageMod'),
                'support_item' => false,
                'screen' => '',
                'info' => ''
            ),
            'locations_list' => array(
                'name' => 'Listă cu locații (cultură)',
                'function' => array('PageView', 'locationsList'),
                'support_item' => true,
                'screen' => '',
                'info' => ''
            ),
            'accordion_list' => array(
                'name' => 'Listă cu întrebări/răspunsuri (FAQ)',
                'function' => array('PageView', 'accordionList'),
                'support_item' => false,
                'screen' => '',
                'info' => ''
            ),
            'town_list' => array(
                'name' => 'Listă primării (orașe)',
                'function' => array('PageView', 'townList'),
                'support_item' => false,
                'screen' => '',
                'info' => ''
            ),
            'tablePosts' => array(
                'name' => 'Postări ca tabel (autorizații)',
                'function' => array('PageView', 'tablePosts'),
                'support_item' => false,
                'screen' => '',
                'info' => ''
            ),
            'urgentNumbers' => array(
                'name' => 'Numere de urgență (numere utile)',
                'function' => array('PageView', 'urgentNumbers'),
                'support_item' => false,
                'screen' => '',
                'info' => ''
            ),
            'acticles' => array(
                'name' => 'Listă articole',
                'function' => array('PageView', 'articleList'),
                'support_item' => true,
                'screen' => '',
                'info' => ''
            ),
            'externLinks' => array(
                'name' => 'Linkuri externe',
                'function' => array('PageView', 'externLinks'),
                'support_item' => false,
                'screen' => '',
                'info' => ''
            ),
            'fileFolders' => array(
                'name' => 'Mape cu fișiere',
                'function' => array('PageView', 'fileFolders'),
                'support_item' => false,
                'screen' => '',
                'info' => ''
            ),
            'acquisitionsList' => array(
                'name' => 'Listă de achiziții',
                'function' => array('PageView', 'acquisitionsList'),
                'support_item' => true,
                'screen' => '',
                'info' => ''
            ),
            'publicConsultations' => array(
                'name' => 'Consultări publice',
                'function' => array('PageView', 'publicConsultations'),
                'support_item' => true,
                'screen' => '',
                'info' => ''
            ),
            'projectsList' => array(
                'name' => 'Listă de proiecte',
                'function' => array('PageView', 'projectsList'),
                'support_item' => true,
                'screen' => '',
                'info' => ''
            ),
            'videoList' => array(
                'name' => 'Listă cu video',
                'function' => array('PageView', 'videoList'),
                'support_item' => true,
                'screen' => '',
                'info' => ''
            ),
            'adsList' => array(
                'name' => 'Anunțuri',
                'function' => array('PageView', 'adsList'),
                'support_item' => true,
                'screen' => '',
                'info' => ''
            ),
            'newsList' => array(
                'name' => 'Știri (Noutățile Primăriei)',
                'function' => array('PageView', 'newsList'),
                'support_item' => true,
                'screen' => '',
                'info' => ''
            ),
            'contactsView' => array(
                'name' => 'Contacte',
                'function' => array('PageView', 'contactsView'),
                'support_item' => false,
                'screen' => '',
                'info' => ''
            ),
            'meetingPast' => array(
                'name' => 'Ședinte anterioare',
                'function' => array('PageView', 'meetingPast'),
                'support_item' => true,
                'screen' => '',
                'info' => ''
            ),
            'meetingFuture' => array(
                'name' => 'Ordinea de zi',
                'function' => array('PageView', 'meetingFuture'),
                'support_item' => false,
                'screen' => '',
                'info' => ''
            ),
            'mapPage' => array(
                'name' => 'Harta site-ului',
                'function' => array('PageView', 'mapPage'),
                'support_item' => false,
                'screen' => '',
                'info' => ''
            ),
            'error404' => array(
                'name' => 'Eroare 404',
                'function' => array('PageView', 'notFound'),
                'support_item' => false,
                'screen' => '',
                'info' => ''
            )
        )
    );
    protected static $colorSchemes = array();
    protected static $page_title = '';
    protected static $breadcrumbs = array();

    /**
     * Initialize module
     * This function is called on bootstrap
     */
    public static function __init() {

        $template = Template::findTemplate();
        Template::setTemplate($template);

        $startup_file = $_SERVER['DOCUMENT_ROOT'] . Template::path('startup.php', 'frontend', \SettingsModel::one('template_frontend'));
        if (file_exists($startup_file)) {
            include $startup_file;
        }
    }

    /**
     * Get current template name
     * @return string
     */
    public static function getCurrent() {
        return self::$template;
    }

    /**
     * 
     * @param array $paths
     * @return string
     */
    public static function preparePaths($paths = array()) {
        $paths = (array) $paths;

        if (isset(self::$module) && self::$module) {
            $paths = array(
                app_path() . '/modules/' . self::$module . '/'
            );
        } else {
            foreach ($paths as &$path) {
                $tpath = $path . '/' . self::$template . '/';
                if (file_exists($tpath)) {
                    $path = $tpath;
                }
            }
        }
        return $paths;
    }

    /**
     * Search current template
     * @return string
     */
    public static function findTemplate() {
        try {
            return \SettingsModel::one('template_' . strtolower(APP_FOLDER));
        } catch (\Illuminate\Database\QueryException $e) {
            return Template::$defaultTemplate;
        }
    }

    /**
     * Set template
     * @param string $template
     */
    public static function setTemplate($template) {
        self::$template = $template;
    }

    /**
     * 
     * @param string $path
     * @return string
     */
    public static function path($path = '', $app = '', $template = '') {
        return "/apps/" . ($app ? $app : APP_FOLDER) . "/views/templates/" . ($template ? $template : self::$template) . "/" . $path;
    }

    /**
     * Load view from module folder
     * @param string $module
     * @param string $view
     * @param mixed $data
     * @return View
     */
    public static function moduleView($module, $view, $data = array()) {
        self::$module = $module;
        $data = View::make($view, $data);
        self::$module = null;
        return $data;
    }

    /**
     * Get main layout
     * @return type
     */
    public static function mainLayout() {
        return View::make('layout.main');
    }

    /**
     * Load view with module prefix
     * @param string $module
     * @param function $callback
     */
    public static function viewModule($module, $callback) {
        static::$module = $module;
        $callback($module);
        static::$module = null;
    }

    /**
     * 
     * 
     * 
     *   VIEW METHODS
     *   functions like Actions component
     * 
     * 
     * 
     */

    /**
     * Register new method
     * @param string $section
     * @param string $tag
     * @param string $name
     * @param mixed $function
     * @param boolean $override
     * @throws Exception
     */
    public static function registerViewMethod($section, $tag, $name, $function, $override = false, $support_item = false, $info = '', $screen = '') {
        if (self::checkViewMethod($section, $tag) && !$override) {
            throw new Exception("Override view method '{$tag}' from '{$section}'");
        } else {
            self::$view_mods[$section][$tag] = array(
                'name' => $name,
                'function' => $function,
                'support_item' => $support_item,
                'screen' => $screen,
                'info' => $info
            );
        }
    }

    /**
     * delete view method
     * @param string $fromSection
     * @param string $tag
     */
    public static function dropViewMethod($fromSection, $tag) {
        unset(self::$view_mods[$fromSection][$tag]);
    }

    /**
     * Verify if exist view method
     * @param string $section
     * @param string $tag
     * @return boolean
     */
    public static function checkViewMethod($section, $tag) {
        return isset(self::$view_mods[$section][$tag]) && $tag && $section;
    }

    /**
     * Call view Method
     * @param string $section
     * @param string $tag
     * @param string $parameters
     * @return mixed
     * @throws Exception
     */
    public static function callViewMethod($section, $tag, $parameters = array()) {
        if (self::checkViewMethod($section, $tag)) {
            return call_user_func_array(self::$view_mods[$section][$tag]['function'], $parameters);
        } else {
            throw new Exception("Undefined view method '{$tag}' in '{$section}'");
        }
    }

    /**
     * Sort view mods (!)
     * @param string $section
     */
    protected static function sordViewMethods($section) {
        if (isset(self::$view_mods[$section])) {
            usort(self::$view_mods[$section], function($a, $b) {
                return $a['name'] > $b['name'];
            });
        }
    }

    /**
     * get list of section methods
     * @param string $section
     * @return array
     */
    public static function getViewMethodList($section) {
        if (isset(self::$view_mods[$section])) {
            //Template::sordViewMethods($section);
            return self::$view_mods[$section];
        } else {
            return array();
        }
    }

    /**
     * 
     * 
     *   END VIEW METHODS
     * 
     * 
     */
    /**
     * 
     *   Breadcrumb
     * 
     */

    /**
     * Add new node in BreadCrumbs
     * @param str $url
     * @param str $name
     */
    public static function addBreadCrumb($url, $name) {
        self::$breadcrumbs[] = array(
            'name' => $name,
            'url' => $url
        );
    }

    /**
     * Get BreadCrumbs list
     * @return array
     */
    public static function getBreadCrumbs() {
        return self::$breadcrumbs;
    }

    /**
     * Clear BreadCrumbs list
     */
    public static function clearBreadCrumbs() {
        self::$breadcrumbs = array();
    }

    /**
     * Set page title
     * @param string $title
     * @param boolean $override
     */
    public static function setPageTitle($title, $override = false) {
        if (static::$page_title) {
            if ($override) {
                static::$page_title = $title;
            }
        } else {
            static::$page_title = $title;
        }
    }

    /**
     * Get Page title
     * @return string
     */
    public static function getPageTitle($page = null) {
        $title = (isset($page['is_home_page']) && $page['is_home_page'] ? '' : static::$page_title . ' :: ');
        $title_g = \SettingsModel::one('sitename_' . Language::ext());
        return $title . $title_g;
    }

    /*
     * 
     * COLOR SCHEMES
     * 
     * 
     */

    /**
     * Set color schemes list
     * @param array $schemeList
     */
    public static function setColorSchemes($schemeList) {
        static::$colorSchemes = $schemeList;
    }

    /**
     * Get currents color schemes from current template
     * @return array
     */
    public static function getColorSchemes() {
        return static::$colorSchemes;
    }

    /**
     * Get current color schema
     * @return boolean
     */
    public static function getCurrentSchema() {
        $schema = \SettingsModel::one('templateSchema');

        if ($schema && isset(static::$colorSchemes[$schema])) {
            return static::$colorSchemes[$schema];
        } else {
            return false;
        }
    }

    /**
     * Get html for current schema
     */
    public static function pullCurrentSchema() {
        $currentSchema = \WebAPL\Template::getCurrentSchema();
        if (isset($currentSchema['css']) && $currentSchema['css']) {
            echo '<link rel="stylesheet" href="' . $currentSchema['css'] . '">';
        }
    }

    /**
     * get list of templates
     * @param string $app
     * @return array
     */
    public static function getTemplates($app = false) {
        if ($app == false) {
            $app = APP_FOLDER;
        }

        $templatesDirs = glob($_SERVER['DOCUMENT_ROOT'] . "/apps/{$app}/views/templates/*", GLOB_ONLYDIR);
        if ($templatesDirs) {
            $templates = [];
            foreach ($templatesDirs as $dir) {
                $templates[] = basename($dir);
            }
            return $templates;
        } else {
            return [];
        }
    }

    /**
     * 
     * 
     *    FACEBOOK META
     * 
     * 
     */
    protected static $meta = array(
        'description' => '',
        'og:title' => '',
        'og:type' => '',
        'og:site_name' => '',
        'og:image' => '',
        'og:description' => ''
    );

    /**
     * Set meta value
     * @param text $key
     * @param text $value
     * @param boolean $override
     */
    public static function setMeta($key, $value, $override = false) {
        $value = \Str::words(strip_tags(trim(preg_replace('/\s\s+/', ' ', $value))), 40);

        if ($override) {
            static::$meta[$key] = $value;
        } else {
            if (isset(static::$meta[$key])) {
                static::$meta[$key] = $value;
            }
        }
    }

    /**
     * Set meta from array
     * @param type $metas
     * @param boolean $override
     */
    public static function setMetaMultiple($metas, $override = false) {
        if (is_array($metas)) {
            foreach ($metas as $key => $meta) {
                static::setMeta($key, $meta, $override);
            }
        }
    }

    /**
     * Get meta
     * @param string $key
     * @return string
     */
    public static function getMeta($key) {
        return isset(static::$meta[$key]) ? static::$meta[$key] : '';
    }

    /**
     * Get all meta
     * @return array
     */
    public static function getMetas() {
        return static::$meta;
    }

}
