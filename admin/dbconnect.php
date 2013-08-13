<?php
	// создаем базу данных и таблицу  gb
	$link = @mysql_connect('mysql.hostinger.ru','u820212374_root','pe104767');
if (!$link) {
    die('Not connected : ' . mysql_error());
}

	$db_selected = @mysql_select_db('u820212374_gb', $link);
if (!$db_selected) {
    die ('Can\'t use db : ' . mysql_error());
}

	$result = @mysql_query('CREATE TABLE IF NOT EXISTS gb (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, username VARCHAR (100), dt DATETIME, msg TEXT)');
if (!$result) {
    die('Invalid query: ' . mysql_error());
}

mysql_query("SET NAMES 'utf8'");

	//mysql_query ("CREATE DATABASE IF NOT EXISTS ".gb) or die ("Can't to create new gb.");
	//mysql_select_db(gb) or die("No conection with db!");
	//mysql_query ("CREATE TABLE IF NOT EXISTS gb (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, username VARCHAR (100), dt DATETIME, msg TEXT)") or die ("Не могу создать таблицу gb.");
?>