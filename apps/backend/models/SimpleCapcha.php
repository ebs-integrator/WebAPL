<?php

class SimpleCapcha {

    public static function make($name, $seed = 0) {
        $im = imagecreate(120, 60);
        $bg = imagecolorallocate($im, 240, 240, 240);

        srand($seed && is_numeric($seed) ? $seed : time());
        $text_colors = array();
        for ($i = 0; $i < 4; $i++) {
            $nr[$i] = rand(0, 9);
            $textcolor = imagecolorallocate($im, rand(50, 150), rand(50, 150), rand(50, 150));
            $text_colors[] = $textcolor;
            imagettftext($im, rand(25, 35), rand(-15, 15), ($i * 27) + 5, rand(35, 50), $textcolor, $_SERVER['DOCUMENT_ROOT'] . res('assets/font/capcha.ttf'), $nr[$i]);
        }
        
        for ($i = 0; $i <= 2; $i++) {
            $line_color = $text_colors[mt_rand(0, count($text_colors)-1)];
            imageline($im, mt_rand(0, 120), 0, mt_rand(0, 120), 60, $line_color);
            imageline($im, 0, mt_rand(0, 60), 120, mt_rand(0, 60), $line_color);
        }

        $codes = implode('', $nr);

        Session::put('capcha_' . $name, $codes);

        ob_start();
        imagepng($im);
        $imagedata = ob_get_contents();
        ob_end_clean();

        return "data:image/png;base64," . base64_encode($imagedata);
    }

    public static function valid($name, $value) {
        $get_value = Session::get('capcha_' . $name);

        return $get_value == $value;
    }
    
    public static function destroy($name) {
        Session::forget('capcha_' . $name);
    }

}
