<? 

/* обработка послания в гостевой книге */
include_once ("head.php");

if (isset($_POST['send']))
	{
	$nomer=$_POST['nomer'];
	$code=$_POST['code'];
	if ($nomer==md5($code))
		{	// получаем переменные из формы
		$msg=($_POST['msg']);
		$user=($_POST['user']);
		$action=$_POST['action'];
		if ($action=="add")
			{	// добавление данных в БД	
			$sql="SELECT id from users WHERE user = '$user'";
			$r1=mysql_query($sql);
			$dat=mysql_fetch_array($r1);
			$id_user=$dat['id'];
			$sql="INSERT INTO gb(id_user, dt, msg) VALUES ('$id_user', NOW(), '$msg')";
			$r=mysql_query ($sql);
		header("Location: ".$_SERVER['SCRIPT_NAME']);	
			}
		}
		else echo "<br>Не верный код подтверждения!";
	}
if (isset($_POST['del']))
{
	$del=$_POST['del'];
	$sql="DELETE FROM `gb` WHERE `id` = $del;";
	$r=mysql_query ($sql);
}
?>

<h1>Гостевая книга</h1>	

<?	/* блок отображения сообщений */

$c=0;
$r=mysql_query ("SELECT * FROM gb ORDER BY dt"); // выбор всех записей из БД, отсортированных так, что самая последняя отправленная запись будет всегда первой.
while ($row=mysql_fetch_array($r))  // для каждой записи организуем вывод.
	{
	$id_user=$row['id_user'];
	$m=mysql_query ("SELECT * FROM users WHERE id = $id_user");
$mow=mysql_fetch_array($m)
?>	
<table class="book_message">
 <tr>
  <td class=image rowspan="2"><img src="<?
	if ($mow['image']=="") echo "images/image_user/trollface.png";
	else echo $mow['image'];
  ?>" alt="<?=$row['username']?>">
  </td>
  <td class="user" ><?=$mow['user']?></td>
  <td class=date><?=rewritedate($row['dt'])?></td>
 </tr>
 <tr>
  <td class=msg colspan="2" ><?=$row['msg']?></td>
 </tr>					
</table>


<?	/* редактораская панель */

if (isset($_SESSION['user'])&&$_SESSION['user']=='feonit'){?>
<form method="post"><!--удаление записи-->
			<input type="hidden" value="<?=$row['id']; ?>" name="del">		
			<td width="50px"><input type="image" src="images/x.png" style="float: left;>				
</form>
<form method="post"><!--редактирование записи-->
	<input type="hidden" value="<?php echo $row['id']; ?>" name="red">
	<input type="image" src="images/y.png" >				
	</td>
</form>	
<?}?>
<?php
$c++;
}
if ($c==0) // если ни одной записи не встретилось
echo "Гостевая книга пуста!<br>";
?>

<br>

<h2>Добавить сообщение</h2>


<?	/* форма отправки сообщения */


$nomer = generate_code();

?>
<!-- код формы -->
<form class=letter method="post">
<input type="hidden" name="action" value="add">
<input type="hidden" name="nomer" value="<?echo md5($nomer)?>">
<table>
<?if (isset($_SESSION['user'])){?>
<input type="hidden" name="user" value="<?=$_SESSION['user']?>">
<?}else{
?>
	<tr>
	 <td>
	  Имя пользователя:
	  <input name="user" value="<?if (isset($_POST['user'])) echo $_POST['user']?>" maxlength="30" required>
	 </td>
	</tr>
<?}?>	
	<tr>
	 <td>Сообщение:</td>
	 <td>&nbsp;</td>
	</tr>
	<tr>
	 <td><textarea  name="msg"   maxlength="1000" required ><?if (isset($_POST['msg'])) echo $_POST['msg']?></textarea>
	 </td>
	</tr>
	<tr>
	 <td>Введите код подтверждения:</td>
	 <td>&nbsp;</td>
	</tr>
	<tr>
	 <td><p><img src="my_codegen.php?nomer=<?=$nomer?>" border="0"></p></td>
	 <td><input type="text" name="code"<?if (isset($_POST['send']))echo "autofocus"?> required></td>
	</tr>
	<tr>
	 <td>&nbsp;</td>
	 <td><input type="submit" value="Отправить сообщение" name="send"></td>
	</tr>
</table>
</form> 
</div>
</div>


           </div>
	      </div>
	     </div>
       </div>    
	  </div>
    <?require_once ("footer.php");?>
  </body>
</html>
