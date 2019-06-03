<?php

  namespace app\utils;

  class AntiBotHelper {

    const FONT_PATH = "/fonts/";

    public static function generateUniqueCode() {
      $VERIFY_CODE_SIZE = 4;
      $randCode = array();
      for ($i=0; $i < $VERIFY_CODE_SIZE; $i++) { 
        array_push($randCode, rand(0,9));
      }

      return join("",$randCode);
    }

    public static function getImageStreamData($str) {
      $x = 100;
      $y = 30;
      $im = imagecreate($x, $y);
      $bg = imagecolorallocatealpha($im, 0, 0, 0, 127);
      for($i = 0; $i < $x; $i++) {
        for($j = 0; $j < $y; $j++) {
            $color = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));
            imagesetpixel($im, $i, $j, $color);
        }
      } 
      $textcolor = imagecolorallocatealpha($im, 255, 255, 255, 0);
      $font = $_SERVER['DOCUMENT_ROOT'] . AntiBotHelper::FONT_PATH . "arial.ttf";
      imagettftext($im, 24, rand(-5,5), 12, 24, $textcolor, $font, $str);

      // Write image to buffer
      ob_start();
      imagepng($im);
      $img = ob_get_clean();
      imagedestroy($im);

      return "data:image/png;base64," . base64_encode($img);;
    }
  }
  
?>