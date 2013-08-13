<?if (isset($_GET['clear'])){$r=mysql_query ("TRUNCATE chat");?><script>window.location.search = '';</script><?}?>
<div class=chat >
  <div class=chat_head ><h3>Мини чат</h3></div>
  <div class=chat_content id=scroll >	
    <div class=chat_row >
     <span id="chatDiv">
	  <?include("1.php")?>
     </span>
    </div>
  </div>
  
	<textarea rows="12" cols="19" wrap="hard" placeholder="" 
	onfocus="if (this.value=='Написать сообщение...'){this.value='';this.style.color='#663300';}" onblur="if (this.value==''){this.value='Написать сообщение...';this.style.color='#dd9966';}">Написать сообщение...</textarea>	
	<p>Отправить Ctrl+Enter</p><br>
	<?
	if (!isset($_SESSION['user'])){
	?>
	<span id="control_num"></span>
	<input type='text' id='control_sum' style='width:20px;padding:2px;'></input>
	<?
	}
	?>
	<input class="button" type="button" id='send'  value="отправить" onclick="CheckAndUpdte();"></input>
	<input class="button" type="button" id='clear' value="очистить" onclick="window.location.search = 'clear=go';"></input>
	<img id="loading" style="display:none" src="images/44.gif"></img>
</div>		

<script type="text/javascript">
function get_cookie(cookie_name) {
  var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
 
  if ( results )
    return ( unescape ( results[2] ) );
  else
    return null;
}
function GetControlSum() {
	var a = Math.floor(Math.random() * (10 - 1 + 1)) + 1;
	var b = Math.floor(Math.random() * (10 - 1 + 1)) + 1;
		control_num = document.getElementById('control_num');
		control_sum = document.getElementById('control_sum');
		control_sum.value='';
	sum = a + b ;
	control_num.innerHTML = 'Сколько будет? ' + a +' + ' + b +' = ';
}
function CheckSum() {
	if (view) return false;//если авторизован ничё проверять не нада
	return (control_sum.value==sum);
}
function getXmlHttp() {
  var xmlhttp;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}
function SetLoading(string){
var loading = document.getElementById('loading');
loading.style.display=string;
}
function update(text) {
text = text || '';
  var req = getXmlHttp();
  var LastID = document.getElementById('LastID');
  			req.onreadystatechange = function() {
				if (req.readyState == 4 && req.status == 200) { 				 
							var chatDiv = document.getElementById('chatDiv');
							if (req.responseText!=''){
							chatDiv.removeChild(LastID);//удалить скрытое поле со временем последней загрузки							
							chatDiv.innerHTML += req.responseText;//добавить ответ сервера в конце которого новое поле времени загрузки														
									scroll();
									SetLoading('none');
							}		
					}
				}
			params = 'LastID=' + LastID.value + '&text=' + text + '&TestCookie=' + get_cookie ( "TestCookie" );
			//req.open('GET', '/1.php?' +params, true); 	
			req.open("POST", '/1.php', true)
			req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			req.send(params);
}
function scroll(){
document.getElementById('scroll').scrollTop = document.getElementById('scroll').scrollHeight ; //опускает ползунок
}

//пользователь авторизован?
view = (document.getElementById('control_num')==null)? true: false;
if (!view)GetControlSum(); //при загрузке скрипта показать контрольную сумму
setInterval(update, 10000); //обновление сообщений
(function() {scroll()
})();

document.getElementsByTagName('textarea')[0].onkeydown = function(event) { //добавление сообщения
event = event || window.event
	if (event.ctrlKey && event.keyCode==13){	
		CheckAndUpdte();
	}
}

function CheckAndUpdte() {
	if (CheckSum()||get_cookie( "TestCookie" )!=null) { //если сумма коректна или пользователь авторизован
		var textarea = document.getElementsByTagName('textarea')[0];	
		SetLoading('inline');
		update(textarea.value);
		textarea.value = '';//обнулить текстовое поле
		GetControlSum();//обновить контрольную сумму
	}
}

</script>
