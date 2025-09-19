<?php
function getNextField(&$num, $mask)
{
    $out = gmp_and($num, $mask);
    $num = gmp_div_q($num, gmp_pow(2, 8));
    return gmp_intval($out);
}

$num = gmp_init($_GET["num"]);
$mask = gmp_init(0b11111111);
$fig = getNextField($num, $mask);
$r = getNextField($num, $mask);
$g = getNextField($num, $mask);
$b = getNextField($num, $mask);
$x = getNextField($num, $mask);
$y = getNextField($num, $mask);
$v1 = getNextField($num, $mask);
$v2 = getNextField($num, $mask);
error_log($fig);
//error_log($x);
//error_log($y);
//error_log($v1);
//error_log($v2);


$width = 256;
$height = 256;

$image = imagecreatetruecolor($width, $height);

$backgroundColor = imagecolorallocate($image, 255, 255, 255);
$figureColor = imagecolorallocate($image, $r, $g, $b);

imagefill($image, 0, 0, $backgroundColor);

if ($fig == 0)
{
    imagefilledellipse($image, $x, $y, $v1, $v1, $figureColor);
}
else if ($fig > 0)
{
    if ($fig == 1)
    {
        imagefilledellipse($image, $x, $y, 5, 5, $figureColor);
    }
    else if ($fig == 2)
    {
        imageline($image, $x, $y, $v1, $v2, $figureColor);
    }
    else
    {
        $arr = [$x, $y, $v1, $v2];
        for ($i = 2; $i < $fig; $i++)
        {
            $nextX = getNextField($num, $mask);
            $nextY = getNextField($num, $mask);
//            error_log($nextX);
//            error_log($nextY);
            array_push($arr, $nextX, $nextY);
        }
        imagefilledpolygon($image, $arr, $figureColor);
    }
}

imagesetpixel($image, 0, 0, $figureColor);
imagesetpixel($image, 127, 127, $figureColor);
imagesetpixel($image, 255, 255, $figureColor);

header('Content-Type: image/png');

imagepng($image);

imagedestroy($image);
?>
