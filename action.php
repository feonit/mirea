<?php
$nomer=$_REQUEST['nomer'];
$code=$_REQUEST['code'];
if (isset($_REQUEST['code']))
{
if ($nomer==$code)
{
echo "Random code: ".$nomer;
echo "Entre cod: ".$code;
echo "<br>Code is true!!!";
	include ("dbconnect.php");

	// получаем переменные из формы
	$username=$_REQUEST['username'];
	$msg=$_REQUEST['msg'];
	$action=$_REQUEST['action'];
	if ($action=="add")// добавление данных в БД
	
		$sql="INSERT INTO gb(username, dt, msg) VALUES ('$username', NOW(), '$msg')";
		$r=mysql_query ($sql);
		}
	else echo "<br>Code is false!!!";
}
else echo "Entre code";

	header("Location: indexx.php");
	#header("Location: ($_SERVER['SCRIPT_NAME'])?".time()); не работает херня
?>