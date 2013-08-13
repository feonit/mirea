<?

require_once ("admin/dbconnect.php");

if (isset($_POST['name'])&&isset($_POST['data'])) { //добавление поста
  $name=$_POST['name'];
  $data=$_POST['data'];
  $sql="INSERT INTO article(name, data) VALUES ('$name', '$data')";
  $r=mysql_query ($sql);
}

include_once ("head.php");

if (isset($_GET['name'])) { //отображение в режиме статьи

?><div class="article"><?
  $name=$_GET['name'];
  $r=mysql_query ("SELECT * FROM article WHERE name = '$name'");	
  $row=mysql_fetch_array($r);
  echo '<h2>'.$row['name'].'</h2><br>';
  echo $row['data'];
?></div><?
}


if (isset($_SESSION['user'])&&$_SESSION['user']=='feonit') {  //вывод панели для меня
?>
<br><br><br><br>
<form method="post">
 <fieldset>
  <legend>  Добавить статью</legend>
   <table class=news_table>
    <tr>
     <td>Заголовок</td>
     <td><input type="text" name="name" required></td>
    </tr>
    <tr>
     <td>Страница</td>
     <td><textarea  name="data" required ></textarea></td>
    </tr>
   </table>
  <input type="submit" value="Отправить сообщение" name="send">
 </fieldset>
</form>
<?
}
?>

           </div>
	      </div>
	     </div>
       </div>    
	  </div>
    <?require_once ("footer.php");?>
  </body>
</html>
