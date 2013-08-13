<?php include_once ("head.php");?>

<?

if (isset($_GET['user']))
	{
	$user=$_GET['user'];
	if (only_char_and_num($user))
	{
	$result=mysql_query ("SELECT * FROM  `users` WHERE  `user` ='$user'"); // выбор одной записи из БД 
	if(!mysql_num_rows($result))
	exit("Нету такого у нас. Ты будешь первым=)") ;
	else
	{
	$row=mysql_fetch_array($result);	
	/*
	echo ($row['id']);
	echo ($row['user']);
	echo ($row['password']);
	echo ($row['image']);
	echo ($row['name']);
	echo ($row['surname']);
	echo ($row['email']);
	echo ($row['job']);
	echo ($row['phone']);*/
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
	<tr><td><?=$row['name']?></td></tr>
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
   </table>
  </div>
 </td>
</table>
<?}}}?>
</div></div>