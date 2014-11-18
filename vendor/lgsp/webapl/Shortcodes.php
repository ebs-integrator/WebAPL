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

class Shortcodes {

    protected static $shortcode_tags = array();

    /**
     * Initialize module
     * This function is called on bootstrap
     */
    public static function __init() {
        
    }

    /**
     * Register new shortcode function
     * @param string $tag
     * @param mixed $function
     */
    public static function register($tag, $function) {
        if (is_callable($function)) {
            self::$shortcode_tags[$tag] = $function;
        }
    }

    /**
     * Remove sortcode function
     * @param string $tag
     */
    public static function remove($tag) {
        unset(self::$shortcode_tags[$tag]);
    }

    /**
     * Verify if exist shortcode
     * @param string $tag
     * @return boolean
     */
    public static function check($tag) {
        return isset(self::$shortcode_tags[$tag]);
    }

    /**
     * Delete all shortcodes
     */
    public static function clear() {
        self::$shortcode_tags = array();
    }

    /**
     * Get regular expression
     * @return type
     */
    protected static function regex() {
        $tagregex = join('|', array_map('preg_quote', array_keys(self::$shortcode_tags)));

        return '\\[(\\[?)(' . $tagregex . ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
    }

    /**
     * verify if content has shortcode
     * @param text $content
     * @param string $tag
     * @return boolean
     */
    public static function has($content, $tag) {
        if (false === strpos($content, '[')) {
            return false;
        }

        if (self::check($tag)) {
            $matches = array();
            preg_match_all('/' . self::regex() . '/s', $content, $matches, PREG_SET_ORDER);
            if (empty($matches)) {
                return false;
            }

            foreach ($matches as $shortcode) {
                if ($tag === $shortcode[2]) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Execute shortcodes
     * @param text $content
     * @return text
     */
    public static function execute($content, $params = array()) {
        if (false === strpos($content, '[')) {
            return $content;
        }

        if (empty(self::$shortcode_tags) || !is_array(self::$shortcode_tags)) {
            return $content;
        }

        return preg_replace_callback("/" . self::regex() . "/s", function ($m) use ($params) {
            return self::exec_tag($m, $params);
        }, $content);
    }

    /**
     * 
     * @param mixed $m
     * @return string
     */
    public static function exec_tag($m, $params = array()) {
        if ($m[1] == '[' && $m[6] == ']') {
            return substr($m[0], 1, -1);
        }

        $tag = $m[2];

        $attrb = self::parse_atts($m[3]);

        $attr = array_merge(is_array($attrb) ? $attrb : array($attrb), $params);
        $attr['tag'] = $tag;
        $attr['c'] = isset($m[5]) ? $m[5] : '';

        return $m[1] . call_user_func(self::$shortcode_tags[$tag], $attr) . $m[6];
    }

    /**
     * Parse attributes
     * @param text $text
     * @return mixed
     */
    protected static function parse_atts($text) {
        $text = htmlspecialchars_decode($text, ENT_QUOTES);

        $atts = array();
        $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
        $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);

        if (preg_match_all($pattern, $text, $match, PREG_SET_ORDER)) {
            foreach ($match as $m) {
                if (!empty($m[1])) {
                    $atts[strtolower($m[1])] = stripcslashes($m[2]);
                } elseif (!empty($m[3])) {
                    $atts[strtolower($m[3])] = stripcslashes($m[4]);
                } elseif (!empty($m[5])) {
                    $atts[strtolower($m[5])] = stripcslashes($m[6]);
                } elseif (isset($m[7]) and strlen($m[7])) {
                    $atts[] = stripcslashes($m[7]);
                } elseif (isset($m[8])) {
                    $atts[] = stripcslashes($m[8]);
                }
            }
        } else {
            $atts = ltrim($text);
        }
        return $atts;
    }

    /**
     * Get attributes
     * @param mixed $pairs
     * @param mixed $atts
     * @param string $shortcode
     * @return type
     */
    protected static function atts($pairs, $atts, $shortcode = '') {
        $atts = (array) $atts;
        $out = array();
        foreach ($pairs as $name => $default) {
            if (array_key_exists($name, $atts))
                $out[$name] = $atts[$name];
            else
                $out[$name] = $default;
        }

        if ($shortcode)
            $out = apply_filters("shortcode_atts_{$shortcode}", $out, $pairs, $atts);

        return $out;
    }

    /**
     * Strip all shortcodes from content
     * @param string $content
     * @return string
     */
    public static function strip($content) {
        if (false === strpos($content, '[')) {
            return $content;
        }

        if (empty(static::$shortcode_tags) || !is_array(static::$shortcode_tags)) {
            return $content;
        }

        $pattern = static::regex();

        return preg_replace_callback("/$pattern/s", array('Shortcodes', 'strip_tag'), $content);
    }

    /**
     * Strip tag
     * @param array $m
     * @return string
     */
    public static function strip_tag($m) {
        if ($m[1] == '[' && $m[6] == ']') {
            return substr($m[0], 1, -1);
        }

        return $m[1] . $m[6];
    }

}
