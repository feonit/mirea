<?php 
include_once ("head.php");
if (isset($_REQUEST['send']))
	{
	$nomer=$_REQUEST['nomer'];
	$code=$_REQUEST['code'];
	if ($nomer==md5($code))
		{	// получаем переменные из формы
		$comment=catch_mat_html($_REQUEST['comment']);
		$username=catch_mat_html($_REQUEST['username']);
		$id=$_REQUEST['id'];
		$action=$_REQUEST['action'];
		if ($action=="add")
			{	// добавление данных в БД			
			$sql="INSERT INTO comment(id_letter, comment, dt, username) VALUES ('$id', '$comment', NOW(),'$username')";
			$r=mysql_query ($sql);
			header("Location: detail.php?id=$id");#header("Location: ($_SERVER['SCRIPT_NAME'])?".time()); не работает херня скобок нет?
			}
		}
		else echo "<br>Code is false!";
	}

if (isset($_GET['id'])&&(is_numeric($_GET['id'])))
	{
	$id=$_GET['id'];
	$r=mysql_query ("SELECT * FROM  `letter` WHERE  `id` =$id"); // выбор одной записи из БД
	$row=mysql_fetch_array($r);
	?>

<div class=detail>
	<table cellspacing="3" cellpadding="0">
		<tr>
			<td>Имя пользователя:</td>
			<td><?php echo ($row['name']); ?></td>			<!--htmlspecialchars чтобы не введённые html символы не были задействованы-->
		</tr>
		<tr>
			<td>Дата опубликования:</td>
			<td><?php echo ($row['job']); ?></td>
		</tr>
		<tr>
			<td>Номер записи:</td>
			<td><div ><?php echo $row['date']; ?> </div></td>
			<td width="100px"><?php echo ($row['money'])."$"; ?></td>
		</tr>
		<tr>
			<td>Контактный телефон:</td>
			<td><?php echo ($row['phone']); ?></td>
		</tr>
					<tr>
			<td>Дисциплина:</td>
			<td><?php echo ($row['disciplina']); ?></td>
		</tr>
					<tr>
			<td>Email:</td>
			<td><?php echo ($row['email']); ?></td>
		</tr>
	</table>
</div>
	<?
	$r=mysql_query ("SELECT * FROM comment WHERE  `id_letter` = $id");
	while ($row=mysql_fetch_array($r))  // для каждой записи организуем вывод.
		{?>
		
		<table border="0" cellspacing="3" cellpadding="0" width="100%"  style="margin: 10px 0px;">
			<tr>
				<td width="150" style="color: #999999;"> Коммент:</td>
				<td><?php echo ($row['comment']); ?></td>			<!--htmlspecialchars чтобы не введённые html символы не были задействованы-->
			</tr>
			<tr>
				<td width="150" style="color: #999999;"> От:</td>
				<td><?php echo ($row['username']); ?></td>			<!--htmlspecialchars чтобы не введённые html символы не были задействованы-->
			</tr>
	<?	}?>
		
	
		<!-- код формы -->
		
	<?	$nomer = generate_code();?>
	<form method="post">
	<h2>Добавить комментарий</h2>
	<input type="hidden" name="id" value="<?=$_GET['id']?>">
	<input type="hidden" name="action" value="add">
	<input type="hidden" name="nomer" value="<?echo md5($nomer)?>">
	<table border="0">
	<?
	if (isset($_SESSION['user'])){?>
	<input type="hidden" name="username" value="<?=$_SESSION['user']?>">
	<?}else	{?>
		<tr>
			<td width="160">
				Имя пользователя:
			</td>
			<td>
				<input name="username" value="<?if (isset($_REQUEST['username'])) echo $_REQUEST['username']?>" style="width: 300px;"maxlength="30" required>
			</td>
		</tr>
	<?		}?>	
		<tr>
			<td width="160" valign="top">
				Сообщение:
			</td>
			<td>
				<textarea  name="comment" style="width: 300px;" maxlength="1000" required ><?if (isset($_REQUEST['comment'])) echo $_REQUEST['comment']?></textarea>
			</td>
		</tr>
		<tr>
			<td width="160">Введите код подтверждения:</td>
			<td width="160">&nbsp;</td>
		</tr>
		<tr>
			<td><p><img src="my_codegen.php?nomer=<?echo $nomer?>" border="0"></p></td>
			<td><input type="text" name="code"<?if (isset($_REQUEST['send']))echo "autofocus"?> required></td>
		</tr>
		<tr>
			<td width="160">&nbsp;</td>
			<td><input type="submit" value="Отправить сообщение" name="send"></td>
		</tr>
	</table>
	</form>
		<?
	}
	else echo "Startup <a href='letter.php'>First page<a/>";	
	?>
	
	</div>
