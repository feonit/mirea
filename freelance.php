<?	/*регистрация*/
include ("function.php");

if (isset($_POST['Go'])&&isset($_POST['user'])&&isset($_POST['password'])&&isset($_POST['email'])) {
$err = array();
		$user=$_POST['user'];
		$email=$_POST['email'];
		$name=$_POST['name'];
		$surname=$_POST['surname'];			
		$password=$_POST['password'];
		$phone=$_POST['phone'];
		$job=$_POST['job'];

	if (ExistUserName($_POST['user'])) //ExistUserEmail($_POST['email']
		$err[] = "Извините, но такой ник или email уже были зарегистрированы, попробуйте другой. ";
		
	if (!only_char_and_num($_POST['user'])) 
		$err[] = "Ник должен состоять только из букв и цифр. ";

	if (!correct_email($_POST['email'])) 
		$err[] = "Введите адрес в виде somebody@server.com. ";
		
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

if (empty($err)) {		
		
		$uniqkey = md5(uniqid(rand()));

		$to      = $email; 
		$subject = 'Регистрация';
		$message = '
		<html>
		<head>
		  <title>Регистрация</title>
		</head>
		<body>
		<p>Вы зарегистрировались на сайте http://mirea.16mb.com. </p>
			<p>Ваш логин: '.$user.'</p>
			<p>Ваш пароль: '.$password.'</p>

		<p>Для завершения \nрегистрации пройдите по этой ссылке: 
		'.$_SERVER['HTTP_REFERER'].'?user='.$_POST['user'].'&uniqkey='.$uniqkey.'</p>

		Благодарим Вас за пользование сервисом, если у Вас есть пожелания и идеи по улучшению сервиса , 
		пожалуйста пишите на http://mirea.16mb.com/book
		<img src="http://mirea.16mb.com/images/kuz.png">
		</body>
		</html>
		';

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		// Additional headers
		$headers .= 'To: Mary <'.$email.'>' . "\r\n";
		$headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";

		// Mail it
		mail($to, $subject, $message, $headers);


		//Array ( [name] => name.png [type] => image/png [tmp_name] => C:\xampp\tmp\php4B2.tmp [error] => 0 [size] => 1772362 ) 
		$file = $_FILES['image']['tmp_name'];
		if (!empty($file)) { 
			if (preg_match('/^([0-9a-za-я_-]*)\.(png|jpg|gif|bmp)$/',$_FILES['image']['name'],$extension)) { //копирование исходного файла
				$newfile = 'images/image_user/tmp/'.$_FILES['image']['name'];
				if (!copy($file, $newfile)) {
					echo "не удалось скопировать ".$_FILES['image']['name']."...\n";
					$newfile="";
				}
				$small_newfile = 'images/image_user/'.$user.'.'.$extension[2];				//создание файла меньшего размера			
				img_resize($newfile, $small_newfile, 100, 100, $rgb=0xffffff, $quality=100);			
			} else {
					$newfile="";
					$small_newfile = "";
					echo "имя файла должно иметь буквы латино-русские, символы только : '-' и '_', расширения файлов только : png|jpg|gif|bmp";
			}
		}
		
		$sql="INSERT INTO users(user, password, uniqkey, name, surname, email, phone, job, image) VALUES ('$user', '$password', '$uniqkey', '$name', '$surname', '$email', '$phone', '$job','$small_newfile')";
		$r=mysql_query ($sql);
		if (!$r) {
		  die('Invalid entry!');
		}			
	}
}

if (isset($_GET['uniqkey'])&&isset($_GET['user'])) {
$uniqkey = $_GET['uniqkey'];
$user = $_GET['user'];
$sql = "SELECT uniqkey FROM users WHERE user='$user'";
$r=mysql_query ($sql);
if (!$r) {
  die('Could not find account!');
}
$row=mysql_fetch_array($r);
 if ($row['uniqkey'] == $uniqkey){
  $sql = "UPDATE users SET uniqkey = 'active' WHERE user = '$user'";
  $r=mysql_query ($sql);
  if (!$r) {
    die('Failed to activate your account!');
  }
 }
}
require ("head.php");
?>
<div class='free'>
<h3>Для регистрации заполните эту форму. Это не тяжело=)</h3>
<?
if (isset($err)){
	if (empty($err)){
		exit('Отлично! Для завершения регистрации пройдите по ссылке высланной вам на почту.!');
	}
	else {
		echo "<ul>";
		foreach ($err as $num => $value) {
			echo '<li>'.($num + 1).'. '.$value.'</li>';	
		}
		echo "</ul>";
	}
}
?>
</div>
</div>

<form class=letter  method="post" enctype="multipart/form-data">
	<input type="text" name="user" required		value=<?if (isset($user)) 		echo$user?>			> Логин *</input><br>
	<input type="text" name="password" required	value=<?if (isset($password))	echo$password?>		> password *</input><br>
	<input type="text" name="email"				value=<?if (isset($email))		echo$email?>		> Email *</input><br> 
  	<input type="text" name="name"              value=<?if (isset($name))		echo$name?>			> Имя</input><br>
	<input type="text" name="surname"           value=<?if (isset($surname))	echo$surname?>		> Фамилия</input><br>
	<input type="text" name="phone" id="phone"  value=<?if (isset($phone))		echo$phone?>		> Контактный телефон</input><br> 	
	<input type="file" name="image"             value=<?if (isset($image))		echo$image?>	><br>
	<textarea type="text" name="job" maxlength='5000' required  id='clearArea' onfocus="if (this.value=='Задания за которые можете браться')this.value=''" onblur="if (this.value=='') this.value='Задания за которые можете браться'">Задания за которые можете браться</textarea><br>
	<input type="submit" value="Регаюсь!" name="Go" >
</form>
  <script type="text/javascript">
var phone = document.getElementById('phone');
phone.onkeypress = function(e) {
  e = e || event;
  
  if (e.ctrlKey || e.altKey || e.metaKey) return;  

  var chr = getChar(e);

  // с null надо осторожно в неравенствах, 
  // т.к. например null >= '0' => true
  // на всякий случай лучше вынести проверку chr == null отдельно
  if (chr == null) return;
  
  if (chr < '0' || chr > '9') {
    return false;
  }
}
function getChar(event) {
  if (event.which == null) {
    if (event.keyCode < 32) return null;
    return String.fromCharCode(event.keyCode) // IE
  }

  if (event.which!=0 && event.charCode!=0) {
    if (event.which < 32) return null;
    return String.fromCharCode(event.which)   // остальные
  }

  return null; // специальная клавиша
}

  </script>
           </div>
	      </div>
	     </div>
       </div>    
	  </div>
    <?require_once ("footer.php");?>
  </body>
</html>

