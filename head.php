<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; Charset=utf-8"> 
  <meta name="keywords" content="Мирэа, работа, зарплата, учёба, курсовые, типовые работы, дипломные"> 

<?
$title = array(	
				'Новости мирэа'=>'index.php',
				'Новый сервис для студентов'=>'main.php',
				'FTP сервер'=>'ftp.php',
				'Объявления'=>'letter.php',
				'Наши фрилансеры'=>'good_people.php',
				'Гостевая книга'=>'book.php'				
);
$menu_active = $_SERVER['SCRIPT_NAME'];
foreach ($title as $part =>$uml)
 if ($menu_active=="/".$uml)
  echo "   <title>".$part."</title>";
?> 
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link type="text/css" rel="stylesheet" media="all" href="cs.css" /> 
  <script type="text/javascript" src="js.js"></script>
  <script type="text/javascript" src="opacity.js"></script>
  <script type="text/javascript">
// Создаем правило изменения прозрачности: задаем имя правила, начальную и конечную прозрачность, а также необязательный параметр задержки влияющий на скорость смены прозрачности
  fadeOpacity.addRule('or', .5, 1, 30);
</script>
 </head>
  <body><?require_once ("admin/dbconnect.php");require_once ("function.php");?>
    <div class="head_site" >
	  <img src="images/logo1.png"style="height:150px;width:300px;">
      <div id="login" style="opacity:0.5;"  onMouseOver="fadeOpacity(this.id, 'or')" onmouseout="fadeOpacity.back(this.id)">
	  <?require_once("login.php");?>
      </div>
      <embed style="position:absolute;height:190px;width:100%;z-index:0;top:-25px;" src="http://www.rusarmia.com/swf_flash/cat_tuhlik.swf" quality="high"  wmode="transparent" type="application/x-shockwave-flash" <="" embed="">
    </div>
    <div class=menu>
<?
$menu = array(	
				'News'=>'/index',
				'Главная'=>'/main',
				'FTP сервер'=>'/ftp',
				'Объявления'=>'/letter',
				'Good people'=>'/good_people',
				'Гостевая книга'=>'/book'
				
);
echo "<ul>";
foreach ($menu as $part =>$uml)
 if ($menu_active==$uml.".php")
  echo "<li ><a class=\"active\" href=\"$uml\">► $part</a></li>\n";
 else
  echo "<li><a href=\"$uml\">$part</a></li>\n";
echo "</ul>";
?>
    </div>
<?
//<div id="job" style="top:1300px; left:800px; position:absolute;z-index:1000;"><img src="images/job.png"></div>
//<div id="ball" style="top:1400px; left:800px; position:absolute;z-index:1000;"><img src="images/ball.gif"></div>
?>
    <div class="body_site">
      <div class="right_side" id="table">
        <div class="article_side">
		  <?include ("article_side.php")?>
		</div>
		<div class="article_side">
		  <div class="ya-site-form ya-site-form_inited_no" onclick="return {'bg': '#468BE1', 'target': '_blank', 'language': 'ru', 'suggest': true, 'tld': 'ru', 'site_suggest': true, 'action': 'http://yandex.ru/sitesearch', 'webopt': false, 'fontsize': 12, 'arrow': true, 'fg': '#000000', 'searchid': '1915796', 'logo': 'rb', 'websearch': false, 'type': 3}"><form action="http://yandex.ru/sitesearch" method="get" target="_blank"><input type="hidden" name="searchid" value="1915796" /><input type="hidden" name="l10n" value="ru" /><input type="hidden" name="reqenc" value="utf-8" /><input type="text" name="text" value="" /><input type="submit" value="Найти" /></form></div><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;(' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1&&(e.className+=' ya-page_js_yes');s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>
		</div>
		
		<div><?require_once ("chat.php")?></div>
        <!--<div style="margin-top:20px;">include ("ftp.php")</div>-->
      </div>
      <div class="left_side">
<script>
function opacity(elem, OnOver) {
//elem.style.opacity = OnOver ? 1 : 0.5;
	if (OnOver) {
	var intervalID = setInterval( function() { 
			if (elem.style.opacity > 0.9)
				clearInterval(intervalID);
			else {		
				elem.style.opacity = Number(Number(elem.style.opacity).toFixed(1)) + 0.1; 
				alert(Number(Number(elem.style.opacity).toFixed(1)) + 0.1);
			}
		} , 1000)
	}
}

var img = document.getElementById('ball');

img.onclick = function() {

  animate({
    delay: 20,
    duration: 1000,
    delta: makeEaseOut(bounce),
    step: function(delta) {
      img.style.top = (screen.availHeight-140)*delta + 'px'
    }
  });


}

</script>

<SCRIPT LANGUAGE="JavaScript">

function fixEvent(e) {
  e = e || window.event;

  if (!e.target) e.target = e.srcElement;

  if (e.pageX == null && e.clientX != null ) { // если нет pageX..
    var html = document.documentElement;
    var body = document.body;

    e.pageX = e.clientX + (html.scrollLeft || body && body.scrollLeft || 0);
    e.pageX -= html.clientLeft || 0;

    e.pageY = e.clientY + (html.scrollTop || body && body.scrollTop || 0);
    e.pageY -= html.clientTop || 0;
  }

  if (!e.which && e.button) {
    e.which = e.button & 1 ? 1 : ( e.button & 2 ? 3 : ( e.button & 4 ? 2 : 0 ) )
  }

  return e;
}

function getCoords(object){
	var regexp = /[0-9-]*/;
			
		str = object.style.left;
	pageX = str.match(regexp);
		str = object.style.top;
	pageY = str.match(regexp);
	
	obj = new Object()		 
		obj = { 
		  left: pageX,
		  top: pageY		
		}
return obj;
}

function getCoordss(elem) {
    // (1)
    var box = elem.getBoundingClientRect();
    
    var body = document.body;
    var docEl = document.documentElement;
    
    // (2)
    var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
    var scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;
    
    // (3)
    var clientTop = docEl.clientTop || body.clientTop || 0;
    var clientLeft = docEl.clientLeft || body.clientLeft || 0;
    
    // (4)
    var top  = box.top +  scrollTop - clientTop;
    var left = box.left + scrollLeft - clientLeft;
    
    // (5)
    return { top: Math.round(top), left: Math.round(left) };
}


var ball = document.getElementById('job');
ball.onmousedown = function(e) { // отследить нажатие
  var self = this;
  e = fixEvent(e);

  var coords = getCoords(this);
  var shiftX = e.pageX - coords.left;
  var shiftY = e.pageY - coords.top;
 


  // подготовить к перемещению
  // разместить на том же месте, но в абсолютных координатах
  this.style.position = 'absolute'; 
  moveAt(e);
  // переместим в body, чтобы мяч был точно не внутри position:relative
  document.body.appendChild(this); 
  
  // передвинуть мяч под координаты курсора   
  function moveAt(e) {

    self.style.left = e.pageX - shiftX + 'px';
    self.style.top = e.pageY - shiftY+ 'px';
  }

  // перемещать по экрану
  document.onmousemove = function(e) {
    e = fixEvent(e);
    moveAt(e);
	
  }



  // отследить окончание переноса
  this.onmouseup = function() {		  
  document.onmousemove = self.onmouseup = null;
  //document.documentElement.style.height='100%';
}
}
ball.ondragstart = function() {
  return false;
};
</SCRIPT>

        <div id="table">
          <div id="whitetable">
