<?
session_start();
//выполнение выхода
if (isset($_POST['come_back'])) {
	session_destroy();
	setcookie ("PHPSESSID", "", time() - 3600);//не удаляется
	setcookie ("TestCookie", "", time() - 3600);
	header("Location: ".$_SERVER['SCRIPT_NAME']);
}
//выполнение попытки входа
if (isset($_POST['come_in'])) {
	$c=0;
	$r=mysql_query ("SELECT user, password, uniqkey FROM users ORDER BY id"); // выбор всех записей из БД, отсортированных так, что самая последняя отправленная запись будет всегда первой.
		while ($row=mysql_fetch_array($r)) {
			if (($row['user']===trim($_POST['user']))&&($row['password']===$_POST['password'])) { //&&$row['uniqkey']==='active'
			$c=1;
			break;
		}
	}
	if ($c==1) {
		$user=$_POST['user'];
		$_SESSION['user']=$user;
		setcookie ("TestCookie", "$user", time() + 3600000);
		header("Location: ".$_SERVER['SCRIPT_NAME']);
	}
	else echo "Bad login or password, please try again. ";
}

if (isset($_SESSION['user'])) {
echo "Welcome <a href='/myinfo'>".$_SESSION['user']."</a>";
?>

<form action="index.php" method="post"> <!-- форма для выхода -->
<center><input type="submit" name="come_back" value="Out"/></center>
</form>

<?
}
else {
?>

<form action="index.php" method="post" > <!-- форма для входа -->
<table>
<tr><td>User name:</td><td><input type="text" name="user"/></td></tr>
<tr><td>Password:</td><td><input type="password" name="password"/></td></tr>
<tr><td colspan="2"><center><input type="submit" name="come_in" value="Login"/></center></td></tr>
</table>
</form>

<?
}
?>
