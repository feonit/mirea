<?

/* добавление новости */
include ("function.php");
if (isset($_POST['send'])) {
	// получаем переменные из формы
	$data=catch_mat_html($_POST['data']);
	$first_data=catch_mat_html($_POST['first_data']);
	
	$head=($_POST['head']);
		// добавление данных в БД						
		$sql="INSERT INTO news(head, user_id, first_data, data, date) VALUES ('$head',1, '$first_data', '$data', NOW())";
		$r=mysql_query ($sql);
		header("Location: ".$_SERVER['SCRIPT_NAME']);	
}	

	/* удаление новости */

if (isset($_POST['del'])) {
	$del=$_POST['del'];
	$r=mysql_query ("DELETE FROM `news` WHERE `id` = $del;");
	header("Location: ".$_SERVER['SCRIPT_NAME']);
}	
if (isset($_POST['red'])) {
	$red=$_Post['red'];
	
	header("Location: ".$_SERVER['SCRIPT_NAME']);
}

	/* блок новостей */
			//$sql="ALTER TABLE  `news` ADD  `first_data` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER  `user_id`";
			//mysql_query($sql);
			
	include_once ("head.php");
$count=mysql_query('SELECT COUNT(data) FROM news');
$count=mysql_fetch_array($count);
$count=$count['COUNT(data)'];

if (isset($_GET['list'])&&($_GET['list']>=1)&&($_GET['list']<=$count)) 
	$list=3*($_GET['list']-1);
else 
	$list=0;
?>
<script type="text/javascript">
function up(indexNum) {

    md = document.getElementById('closeDiv'+indexNum);
	img = document.getElementById('closeDivImg'+indexNum);
			if (md.style.display=='none'){
			img.src='images/action_remove.png';
			md.style.display='block';
			}
			else{
			md.style.display='none';
			img.src='images/action_add.png';}
}
</script>
<?
if (isset($_GET['news'])&&Num($_GET['news']))
							$OneNewsMode = true; 
					else    $OneNewsMode = false;

if ($OneNewsMode) {
	$NumNews=$_GET['news'];
	$r=mysql_query ("SELECT * FROM news WHERE id=$NumNews");
} else {
	$r=mysql_query ("SELECT * FROM news ORDER BY id DESC LIMIT $list , 3");
}
$indexNum=1;
while($row=mysql_fetch_array($r))  // для каждой записи организуем вывод.
{
													//$data=$row['data'];$id=$row['id'];$sql="UPDATE `news` SET first_data='$data' WHERE id='$id'";$ri=mysql_query ($sql);
?>
  <script type="text/javascript">
// Создаем правило изменения прозрачности: задаем имя правила, начальную и конечную прозрачность, а также необязательный параметр задержки влияющий на скорость смены прозрачности
  fadeOpacity.addRule('plus', .3, 1, 10);
</script>
<div class="news">
	<div class="head" onclick="up(<?=$indexNum;?>);">
		<? echo $row['head']; ?>
		<img style="opacity:0.3;float: right;" id="closeDivImg<?=$indexNum;?>"  onMouseOver="fadeOpacity(this.id, 'plus')" onmouseout="fadeOpacity.back(this.id)" src="images/action_remove.png">
	</div>
	<div class="date">
	<? echo rewritedate($row['date']); ?>
	</div>	
	<div class="data" id="closeDiv<?=$indexNum++;?>" style="overflow: hidden;">
	<?if (!$OneNewsMode)
		echo $row['first_data'];
			else echo $row['data'];?>
	<?if (!$OneNewsMode) 
		echo "<a href=".$_SERVER['SCRIPT_NAME']."?news=".$row['id'].">Читать полностью</a>";
			else echo "<a href=".$_SERVER['HTTP_REFERER'].">назад</a>";
	?>
	</div>
</div>

<?	/* редактораская панель */		

if (isset($_SESSION['user'])&&$_SESSION['user']=='feonit'){?>
<form method="post"><!--удаление записи-->
			<input type="hidden" value="<?=$row['id']; ?>" name="del">		
			<td width="50px"><input type="image" src="images/x.png" style="float: left;>				
</form>
<form  method="post"><!--редактирование записи-->
	<input type="hidden" value="<?=$row['id']; ?>" name="red">
	<input type="image" src="images/y.png" >				
	</td>
</form>	
<?}?>
<?}?>

<div class="list">

<?
$col=(int)($count/3);
if ($count%3>0)$col++;
for($i=1;$i<=$col;$i++){?>
<a href="<?$_SERVER['SCRIPT_NAME']?>?list=<?=$i?>"><?=$i?><?if ($i<$col){?>|<?}?></a>
<?}?>
</div>

<?	/* добавление новостей только от меня */

if (isset($_SESSION['user'])&&($_SESSION['user']=='feonit'))
	{
?>
		
<form method="post">
 <fieldset>
 <h5>Разрешены:<br>
		вставка картинок -[img]URL[left|right]<br>
		курсив - [i][/i]<br>
		жирное начертание - [b][/b]<br>
</h5>
  <legend>  Добавить новость</legend>
   <table class=news_table>
    <tr>
     <td>Заголовок</td>
     <td><input type="text" name="head" required></td>
    </tr>
	 <tr>
     <td>Краткая новость</td>
     <td><textarea  name="first_data" required ></textarea></td>
    </tr>
    <tr>
     <td>Новость</td>
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
