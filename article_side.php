<?	

//$sql="CREATE TABLE IF NOT EXISTS article (name TEXT, data TEXT)";//
//$sql1="ALTER TABLE  `article` ADD  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
//$sql2="ALTER TABLE  `article` ADD  `id` INT NOT NULL AUTO_INCREMENT ,ADD PRIMARY KEY (  `id` )";
//$sql3="ALTER TABLE  `article` ADD  `group` INT NOT NULL DEFAULT '1'";
//$sql4="ALTER TABLE  `article` ADD  `group_name` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL";
//$sql5="INSERT INTO article(name, data) VALUES ('хрень печальная', 'жил был хрень')";

?> <p><h3>Полезные статьи</h3></p> <?
  $r=mysql_query ("SELECT name FROM article ORDER BY id"); // выбор всех записей из БД, отсортированных так, что самая последняя отправленная запись будет всегда первой.
  while ($row=mysql_fetch_array($r))  // для каждой записи организуем вывод.
	{
	echo "<a href='article.php?name=" . $row['name'] . "'>".$row['name']."</a><br>";
	}
?>