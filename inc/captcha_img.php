<?php

//STARTING  SESSION
    session_start();

//GENERATING RANDOM 4 CHARACTER FOR CAPTCHA
    $string = 'abcdefhjkmnpqrstuvwxyz23456789';
    $text = substr(str_shuffle($string), 0, 4);

//CREATING SESSION
    $_SESSION['captcha'] = $text;

//CREATING IMAGE TEMPLATE WITH SIZE 120x40
    $image_width  = 120;
    $image_height = 40;
    $image = imagecreate($image_width, $image_height);

//DEFINING BACKGROUND COLOUR
    imagecolorallocate($image, 232, 232, 232);

//FOR LOOP FOR CREATING TEXT IN IMAGE
    for ($i=0; $i<4; $i++){
    //CREATING RANDOM FONT-SIZE
        $font_size = rand(20, 23);
    //RANDOM ORIENTATION AND POSITION
        $o = rand(-20, 20);
        $x = 12 + ($i * 26);
        $x = rand($x-3, $x+3);
        $y = rand(24, 30);
    //FONT RANDOM COLOUR
        $r = rand(0, 160);
        $g = rand(0, 160);
        $b = rand(0, 160);
    //FONT COLOR
        $font_color = imagecolorallocate($image, $r ,$g, $b);
    //CREATING CHARACTER WITH SELECTED FONT IN IMAGE
        imagettftext($image, $font_size, $o, $x, $y, $font_color,
                dirname(__FILE__).'/fonts/ConsolasBold.ttf', $text[$i]);
    }

//FOR LOOP FOR CREATING RANDOM LINES
    for($i=1; $i<=15; $i++){
    //RANDOM STARTING AND ENDING POSITION 
        $x1 = rand(0, 120);
        $y1 = rand(0, 40);
        $x2 = rand(0, 120);
        $y2 = rand(0, 40);
    //RANDOM COLOR
        $r = rand(0, 255);
        $g = rand(0, 255);
        $b = rand(0, 255);
        $line_color = imagecolorallocate($image, $r ,$g, $b);
    //CREATING RANDOM LINES
        imageline($image, $x1, $y1, $x2, $y2, $line_color);
    }

//CREATING FINAL IMAGE - PNG CAPTCHA
    header('content-type: image/png');
    imagepng($image);
    imagedestroy($image);

?>
