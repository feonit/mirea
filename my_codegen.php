<?
$nomer=$_REQUEST['nomer'];
{// ��� �� �� ������������ ��������
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                     // ���� � �������
header("Last-Modified: " . gmdate("D, d M Y H:i:s", 10000) . " GMT"); // 1 ������ 1970
header("Cache-Control: no-store, no-cache, must-revalidate");         // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);            // ��� ���, ��� ����������
header("Pragma: no-cache");                                           // HTTP/1.0
header("Content-Type:image/png"); 
}

$im = imagecreatefrompng ('my_codegen/codegen.png'); // ��������� ���
$color = imagecolorallocate($im, rand(0, 200), 0, rand(0, 200)); // ���� ������
imagettftext ($im, 15, rand(-4, 4), rand(10, 45), rand(20, 35), $color, 'my_codegen/trebucbd.ttf', $nomer); //��� ����� � �������� ��������

ImagePNG ($im); // ����� �����������
ImageDestroy ($im); // ����������� ������



?>