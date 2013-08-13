<?php 
include ("function.php");
	  
if (isset($_POST['send']))
	{
	$nomer=$_POST['nomer'];
	$code=$_POST['code'];

	if ($nomer==$code)
		{
		$name=$_POST['name'];// получаем переменные из формы
		$phone=$_POST['phone'];
		$email=$_POST['email'];
		$disciplina=$_POST['disciplina'];
		$job=$_POST['job'];
		$money=$_POST['money'];	
		$sql="INSERT INTO letter(name, phone, email, disciplina, job, money, date) VALUES ('$name','$phone','$email','$disciplina','$job','$money', NOW())";
		$r=mysql_query ($sql);
		header("Location: ".$_SERVER['SCRIPT_NAME']);
		}
	else echo "<br>Не верный код подтверждения!";
	}
?>
<?php require ("head.php")?>

  <?php
	$c=0;
	$r=mysql_query ("SELECT * FROM letter ORDER BY date"); // выбор всех записей из БД, отсортированных так, что самая последняя отправленная запись будет всегда первой.
	while ($row=mysql_fetch_array($r))  // для каждой записи организуем вывод.
	{
		if ($c%2)
			$col="bgcolor='#f9f9f0'";	// цвет для четных записей
		else
			$col="bgcolor='#f0f0f5'";	// цвет для нечетных записей
			
			?>
			<table border="0" cellspacing="3" cellpadding="0" width="100%" <? echo $col; ?> style="margin: 10px 0px;">
			<tr>
				<td width="150" style="color: #999999;">Имя пользователя:</td>
				<td><?php echo htmlspecialchars($row['name']); ?></td>			<!--htmlspecialchars чтобы не введённые html символы не были задействованы-->
			</tr>
			<tr>
				<td width="150" style="color: #999999;">Задание:</td>
				<td><?php echo htmlspecialchars($row['job']); ?></td>
			</tr>
			<tr>
				<td width="150" style="color: #999999;">Дата объявления:</td>
				<td><div ><?php echo $row['date']; ?> </div></td>
				<td class=money width="100px"><?php echo htmlspecialchars($row['money']); ?><img style="height: 1.5ex;" src="images/ruble.gif"></td>
			</tr>
			<tr>
			<td></td>
			<td></td>
			<td><a href="detail.php?id=<?=$row['id']?>">читать далее</a></td>
			</tr>
			</table>
			<?php
		$c++;
	}
	
	if ($c==0) // если ни одной записи не встретилось
		echo "Гостевая книга пуста!<br>";
	

?>
</div>
<h2>Дать объявление</h2>
<form id="data" class=letter method="post" >
<table>
	<tr>
	 <td>Имя *</td>
	 <td><input name=name type="text" maxlength=15 required> </input>
	</td>
	</tr>
	<tr>
	 <td>Номер телефона *</td>
	 <td>	<input name=phone type="text" maxlength=15 > </input></td>
	</tr>
	<tr>
	 <td>Email *</td>
	 <td>	<input name=email type="email"> </input></td>
	</tr>
	<tr>
	 <td>Плата(В рублях)</td>
	 <td><input name=money type="text" maxlength=10 required> </input><br></td>
	</tr>
	<tr>
	 <td>Предмет</td>
	 <td>	<select name=disciplina form="data" >	<option>Матанализ</option>
											<option>Линейная алгебра</option>
											<option>Дифференциальные уравнения</option>
											<option>Программирование</option>
											<option>Информатика</option>
											<option>Физика</option>
											</select>
	 </td>
	</tr>
</table>

<textarea name=job type="text" maxlength=5000 required> Само задание</textarea><br>
<?
$nomer = generate_code();//function.php
?>
		<input type="hidden" name="nomer" value="<?echo $nomer?>">
		<p>Введите код подтверждения:</p>
		<p><img src="my_codegen.php?nomer=<?echo $nomer?>" border="0"></p>
		<p><input type="text" name="code"<?if (isset($_POST['send']))echo "autofocus"?> required></p>
	<input type="submit" value="Отправить сообщение" name="send">
</form>
 

           </div>
	      </div>
	     </div>
       </div>    
	  </div>
    <?require_once ("footer.php");?>
  </body>
</html>
