<?
require_once ("admin/dbconnect.php");
require_once ("function.php");
$NowTime = time(); //unix time


//$r=mysql_query("ALTER TABLE  `chat` ADD  `info` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL");

//ловим переменные
if (isset($_POST['LastID'])) { //если отображение не первое
	$LastID = $_POST['LastID'];
	$user = $_POST['TestCookie'];
	$text = htmlspecialchars($_POST['text']);
	}
		else $LastID = 0;
			

if (isset($_POST['text'])&&!empty($_POST['text'])) { //добавление ещё одной записи
		{$glob = "REMOTE_ADDR 		- ".$_SERVER['REMOTE_ADDR']. "\n" .
				"REMOTE_HOST 		- ".$_SERVER['HTTP_USER_AGENT']. "\n" .
				"REMOTE_PORT 		- ".$_SERVER['HTTP_USER_AGENT']. "\n" .
				"SERVER_PROTOCOL 	- ".$_SERVER['SERVER_PROTOCOL']. "\n" .
				"REQUEST_METHOD 	- ".$_SERVER['REQUEST_METHOD']. "\n" .
				"QUERY_STRING 		- ".$_SERVER['QUERY_STRING']. "\n" .
				"HTTP_ACCEPT 		- ".$_SERVER['HTTP_ACCEPT']. "\n" .
				"HTTP_CONNECTION 	- ".$_SERVER['HTTP_CONNECTION']. "\n" .
				"HTTP_REFERER 		- ".$_SERVER['HTTP_REFERER']. "\n" .
				"HTTP_USER_AGENT 	- ".$_SERVER['HTTP_USER_AGENT'];
		}	
		$r=mysql_query ("INSERT INTO chat(msg, user, date, info) VALUES ('$text', '$user', $NowTime, '$glob')");
}
$new=0;

$r=mysql_query("SELECT * from chat WHERE  id > $LastID"); //отображение всех начиная с last
if ($r) {	
	while ($row=mysql_fetch_array($r)) {
		echo "<div><h5>".$row['user']."<h6>".date( 'H:h:i d F', $row['date'])."</h6></h5>".$row['msg']."</div>";
		$LastID=$row['id'];
		$new=1;
	}
if ($new) echo " <input type='hidden' id='LastID' value=".$LastID."></input>";
}?>