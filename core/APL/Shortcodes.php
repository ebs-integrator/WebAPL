<?php

namespace Core\APL;

class Shortcodes {

    protected static $shortcode_tags = array();

    public static function __init() {
        
    }

    public static function register($tag, $function) {
        if (is_callable($function)) {
            self::$shortcode_tags[$tag] = $function;
        }
    }

    public static function remove($tag) {
        unset(self::$shortcode_tags[$tag]);
    }

    public static function check($tag) {
        return isset(self::$shortcode_tags[$tag]);
    }

    public static function clear() {
        self::$shortcode_tags = array();
    }

    protected static function regex() {
        $tagregex = join('|', array_map('preg_quote', array_keys(self::$shortcode_tags)));

        return '\\[(\\[?)(' . $tagregex . ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
    }

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

    public static function execute($content) {
        if (false === strpos($content, '[')) {
            return $content;
        }

        if (empty(self::$shortcode_tags) || !is_array(self::$shortcode_tags)) {
            return $content;
        }

        return preg_replace_callback("/" . self::regex() . "/s", function ($m) {
            return self::exec_tag($m);
        }, $content);
    }

    public static function exec_tag($m) {
        if ($m[1] == '[' && $m[6] == ']') {
            return substr($m[0], 1, -1);
        }

        $tag = $m[2];
        $attr = self::parse_atts($m[3]);

        if (isset($m[5])) {
            return $m[1] . call_user_func(self::$shortcode_tags[$tag], $attr, $m[5], $tag) . $m[6];
        } else {
            return $m[1] . call_user_func(self::$shortcode_tags[$tag], $attr, null, $tag) . $m[6];
        }
    }

    protected static function parse_atts($text) {
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

}
