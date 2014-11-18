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
