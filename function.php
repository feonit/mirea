<?
require_once ("admin/dbconnect.php");

function generate_code() #возвращает строку
{
    $week_day = date("w");              // день недели
    $day = date("d");                   // число
    $hours = date("H");                 // час
    $minuts = substr(date("H"), 0 , 1); // минуты (первая цифра)
    $mouns = date("m");                 // месяц
    $year_day = date("z");              // день в году

    $str = $week_day . $day . $hours . $minuts . $mouns . $year_day; // формируем результирующую строку

    $array_mix = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY); // разбиваем сроку на символы и заносим их в массив
    srand ((float)microtime()*1000000); // запускаем генератор случейных чисел
    shuffle ($array_mix); // перемешиваем значения в массиве
    return implode("", $array_mix); // объединяем все значения массива в строку и возвращаем
}
// коректность имён
function only_char_and_num($string) {
return preg_match("/^[0-9a-zа-я]+$/ui", $string); 
}
function only_char($string) {
return preg_match("/^[a-zа-я]+$/ui", $string); 
}
function only_num($string) {
return preg_match("/^[0-9]{11}$/ui", $string); 
}
function Num($string) {
return preg_match("/^[0-9]{1,5}$/ui", $string); 
}

// Проверяем корректность e-mail
function correct_email($string) {
return preg_match("/^[0-9a-z]+@[0-9a-z_^\.]+\.[a-z]{2,3}$/i", $string); 
}

function catch_mom($string) {
$string=htmlspecialchars($string);
	$search=array('хуй','пизд','еба','ёб','трах','пидор');// проверяем мат
	$replace=array('Плохо','Некультурно','ТЬФУ','ХМ','ПЫХ','нетакой');
	$string = str_ireplace($search,$replace,$string);

	$string = preg_replace('#(.){3,}#', '\1\1\1', $string);//Удаление многократно повторяющихся знаков препинания
	return $string;	
}

function catch_mat_html($string)
{
	$string=htmlspecialchars($string);
	$search=array('хуй','пизд','еба','ёб','трах','пидор');// проверяем мат
	$replace=array('Плохо','Некультурно','ТЬФУ','ХМ','ПЫХ','нетакой');
	$string = str_ireplace($search,$replace,$string);

	$string = str_replace("[b]","<b>",$string);
	$string = str_replace("[/b]","</b>",$string);
	$string = str_replace("[i]","<i>",$string);
	$string = str_replace("[/i]","</i>",$string);
	$string = str_replace("`","'",$string);
	//$string = preg_replace('#(\n|\r|\t|\w|\.|\?|!|\(|\)){3,}#', '\1\1\1', $string);//Удаление многократно повторяющихся знаков препинания
	
	
	$string = preg_replace('/^/','<p>',$string);
	$string = preg_replace('/\n/','</p>\n<p>',$string);
	$string = preg_replace('/$/','</p>',$string);

	
	preg_match("%\[\i\mg\](.*)\[(left|right)\]%",$string,$out); //полный регулярный поиск
	$size = getimagesize($out[1]);
	$search=array('[img]','[left]','[right]');// проверяем допустимые теги	
	$replace=array("<img $size[3] align=$out[2] src=\"","\">","\">");
	
	return str_ireplace($search,$replace,$string);//[img]images/bg.jpg[]
}
function ExistUserName($name)
{	
	$rezult=false;
	$rus = array("А","а","В","Е","е","К","М","Н","О","о","Р","р","С","с","Т","Х","х");
	$eng = array("A","a","B","E","e","K","M","H","O","o","P","p","C","c","T","X","x");
	$eng_name = str_replace($rus, $eng, $name);
	$rus_name = str_replace ($eng, $rus, $name);
	$query = 	"SELECT * FROM users
				WHERE 	user LIKE '$name' OR
						user LIKE '$eng_name' OR
						user LIKE '$rus_name'";
	$ath = mysql_query($query);
	if($ath) {
		if(mysql_num_rows($ath)>0) $rezult=true;
		return $rezult;
	}
}

function ExistUserEmail($email) {	
	$rezult=false;
	$query = 	"SELECT * FROM users
				WHERE  email LIKE '$email'";
	$ath = mysql_query($query);		
	if($ath) {
		if(mysql_num_rows($ath)>0) $rezult=true;
		return $rezult;
	}
}


function img_resize($src, $dest, $width, $height, $rgb=0xffffff, $quality=100) {
  if (!file_exists($src)) return false;
    $size = getimagesize($src);
  if ($size === false) return false;

  // Определяем исходный формат по MIME-информации, предоставленной
  // функцией getimagesize, и выбираем соответствующую формату
  // imagecreatefrom-функцию.
  $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
  $icfunc = "imagecreatefrom" . $format;
  if (!function_exists($icfunc)) return false;

  $x_ratio = $width / $size[0];
  $y_ratio = $height / $size[1];

  $ratio       = min($x_ratio, $y_ratio);
  $use_x_ratio = ($x_ratio == $ratio);

  $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
  $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
  $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
  $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

  $isrc = $icfunc($src);
  $idest = imagecreatetruecolor($width, $height);

  imagefill($idest, 0, 0, $rgb);
  imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, 
    $new_width, $new_height, $size[0], $size[1]);

  imagejpeg($idest, $dest, $quality);

  imagedestroy($isrc);
  imagedestroy($idest);

  return true;

}
//2012-03-24 09:31:50
	function replace($m) {
	switch($m[2]) {
	case 01: $m[2] = 'января';break;
	case 02: $m[2] = 'февраля';break;
	case 03: $m[2] = 'марта';break;
	case 04: $m[2] = 'апреля';break;
	case 05: $m[2] = 'мая';break;
	case 06: $m[2] = 'июня';break;
	case 07: $m[2] = 'июля';break;
	case 08: $m[2] = 'августа';break;
	case 09: $m[2] = 'сентября';break;
	case 10: $m[2] = 'октября';break;
	case 11: $m[2] = 'ноября';break;
	case 12: $m[2] = 'декабря';	break;
	}
	return $m[3].' '.$m[2].' '.$m[1];//.' '.$m[4].':'.$m[5];
	}
function rewritedate($string) {
$subject = $string;
$pattern = '/^([0-9]{4})-([0-9]{2})-0?([1-3]?[0-9]) ([0-9]{2}):([0-9]{2}):([0-9]{2})/';

//$replacement = '\3 \2 \1 \4:\5';
return preg_replace_callback($pattern, "replace", $subject);

}
//img_resize("C:/xampp/htdocs/mirea/images/image_user/feonit.jpg", "C:/xampp/htdocs/mirea/images/image_user/feonit2.jpg", 100, 100, $rgb=0xffffff, $quality=100);
/*
Функция img_resize(): генерация thumbnails
    Параметры:
      $src             - имя исходного файла
      $dest            - имя генерируемого файла
      $width, $height  - ширина и высота генерируемого изображения, в пикселях
    Необязательные параметры:
      $rgb             - цвет фона, по умолчанию - белый
      $quality         - качество генерируемого JPEG, по умолчанию - максимальное (100)
*/

?>