<?
$nomer=$_REQUEST['nomer'];
{// что бы не кэшировалась картинка
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                     // дата в прошлом
header("Last-Modified: " . gmdate("D, d M Y H:i:s", 10000) . " GMT"); // 1 января 1970
header("Cache-Control: no-store, no-cache, must-revalidate");         // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);            // еще раз, для надежности
header("Pragma: no-cache");                                           // HTTP/1.0
header("Content-Type:image/png"); 
}

$im = imagecreatefrompng ('my_codegen/codegen.png'); // загружаем фон
$color = imagecolorallocate($im, rand(0, 200), 0, rand(0, 200)); // цвет текста
imagettftext ($im, 15, rand(-4, 4), rand(10, 45), rand(20, 35), $color, 'my_codegen/trebucbd.ttf', $nomer); //сам текст в пределах картинки

ImagePNG ($im); // вывод изображения
ImageDestroy ($im); // Освобождаем память



?>