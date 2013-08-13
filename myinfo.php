<?
ob_start();
require_once ("head.php");
if (isset($_POST['Go'])&&isset($_POST['user'])&&isset($_POST['password'])&&isset($_SESSION['user'])) {
$err = array();
		$olduser=$_SESSION['user'];
		$user=$_POST['user'];
		$name=$_POST['name'];
		$surname=$_POST['surname'];			
		$password=$_POST['password'];
		$phone=$_POST['phone'];
		$job=$_POST['job'];
		$image=$_POST['image'];
		
	if ($olduser!== $user) //если ник поменялся
		if (ExistUserName($_POST['user'])) //ExistUserEmail($_POST['email']
			$err[] = "Извините, но такой ник или email уже были зарегистрированы, попробуйте другой. ";
			
	if (!only_char_and_num($_POST['user'])) 
		$err[] = "Ник должен состоять только из букв и цифр. ";
	
	if (!empty($_POST['name'])){	
		if (!only_char($_POST['name'])) 
			$err[] = "Введите ваше имя. Оно из букв! ";	
	}	
	if (!empty($_POST['surname'])){	
		if (!only_char($_POST['surname'])) 
			$err[] = "Введите вашу фамилию. Она из букв!";
	}
	if (!empty($_POST['phone'])){	
		if (!only_num($_POST['phone'])) 
			$err[] = "Введите свой мобильный номер, в виде 89031112233";
	}
	
	$file = $_FILES['image']['tmp_name'];
	if (!empty($file)&&empty($err)) { 
		if (preg_match('/^([0-9a-za-я_-]*)\.(png|jpg|gif|bmp)$/',$_FILES['image']['name'],$extension)) { //копирование исходного файла
			$newfile = 'images/image_user/tmp/'.$_FILES['image']['name'];
			if (!copy($file, $newfile)) {
				$err[] = "не удалось скопировать ".$_FILES['image']['name']."...\n";
			}
			$small_newfile = 'images/image_user/'.$user.'.'.$extension[2];				//создание файла меньшего размера			
			if (!empty($image))unlink($image);//удаление старой фотки 
			img_resize($newfile, $small_newfile, 100, 100, $rgb=0xffffff, $quality=100);			
		} else {
				$err[] = "имя файла должно иметь буквы латино-русские, символы только : '-' и '_', расширения файлов только : png|jpg|gif|bmp";
		}
	} else $small_newfile=$image;


	if (empty($err)){
		$small_newfile = preg_replace("/\/$olduser\./", "/".$user.".", $small_newfile);
		rename($image,$small_newfile);
		$sql = "UPDATE `users` SET user='$user', password='$password', name='$name', surname='$surname', phone='$phone', job='$job', image='$small_newfile' WHERE user='$olduser'";
		echo $sql;
		$r=mysql_query ($sql); 
		
		if (!$r) {
			die('Ошибка базы!'. mysql_error());
		} else {
			include_once ("head.php");
			echo ('Изменения прошли успешно!');
			$_SESSION['user'] = $user; //перезаписать имя юзера в сессии
			//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
			//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
			//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
			header("Pragma: no-cache"); // HTTP/1.0
			header("Location: ".$_SERVER['SCRIPT_NAME']); //что бы новое имя вступило в силу в сессии
		}
	}
	else{
		include_once ("head.php");
		echo "<ul>";
		foreach ($err as $num => $value) {
			echo '<li>'.($num + 1).'. '.$value.'</li>';	
		}
		echo "</ul>";
	}
}

if (isset($_SESSION['user']))
	{
	$user=$_SESSION['user'];
	$r=mysql_query ("SELECT * FROM  `users` WHERE  `user` ='$user'"); // выбор одной записи из БД
	$row=mysql_fetch_array($r);	
	
	$user=$row['user'];	
	$email=$row['email'];
	$name=$row['name'];
	$surname=$row['surname'];			
	$password=$row['password'];
	$phone=$row['phone'];
	$job=$row['job'];
	$image=$row['image'];

ob_end_flush();
?>
<table class=info>
 <tr>
  <td>
   <div class=info_left>
	<table >
	 <tr>
	  <td>
	   <img src="<?=$row['image']?>" width="100" height="100" alt="<?=$row['user']?>">
	  </td>
	 </tr>
	<tr><td><?=$row['name'].' '.$row['surname']?></td></tr>
   </table>
  </div>
 </td>
 <td>
  <div class=info_right>
   <table >
	 <tr>
	  <td>
	   <h1><?=$row['user']?></h1>
	  </td>
	 </tr>
	<tr><td><?=$row['job']?></td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td><h2>Контактная информация</h2></td></tr>
	<tr><td>e-mail <b><?=$row['email']?></b></td></tr>
	<tr><td>phone <b><?=$row['phone']?></b></td></tr>
	
   </table>
  </div>
 </td>
</table>

<SCRIPT LANGUAGE="JavaScript">
function take(){
var data = document.getElementById('data');
data.style.display='block';
}
</script>
<span onclick="take()" style="color:green; border-bottom:1px solid green; cursor: pointer;" >Редактировать данные.</span>

<form id="data" style="display:none" class=letter  method="post" enctype="multipart/form-data">
	<input type="text" name="user" required		value=<?=$user?>			> Логин *</input><br>
	<input type="text" name="password" required	value=<?=$password?>		> password *</input><br>
	<input type="text" name="email"				value=<?=$email?>		> Email *</input><br> 
  	<input type="text" name="name"              value=<?=$name?>			> Имя</input><br>
	<input type="text" name="surname"           value=<?=$surname?>		> Фамилия</input><br>
	<input type="text" name="phone"             value=<?if(!empty($phone)) echo $phone?>		> Контактный телефон</input><br> 	
	<input type="file" name="image"         			><?=$image?></input>
	<input type="hidden" name="image"      value=<?=$image?> ></input>
 <textarea name="job" required 	 maxlength='5000' 
	 onfocus="if (this.value=='Задания за которые можете браться')this.value=''" 
	 onblur="if (this.value=='') this.value='Задания за которые можете браться'"
													 ><?if (isset($job))	echo$job?></textarea><br>
	<input type="submit" value="Сохранить изменения" name="Go">
</form>
	<?
	}
	else echo "No autorizethion!";
?>
           </div>
	      </div>
	     </div>
       </div>    
	  </div>
    <?require_once ("footer.php");?>
  </body>
</html>
