 <?php include_once ("head.php");
 
	$r=mysql_query ("SELECT * FROM  `users` "); // выбор одной записи из БД WHERE  `uniqkey` ='active'
while ($row=mysql_fetch_array($r))  {
?>
<table class=info>
 <tr>
  <td>
   <div class=info_left>
	<table >
	 <tr>
	  <td>
	   <a href="man.php?user=<?=$row['user']?>"><img src="<?=$row['image']?>" width="100" height="100" alt="<?=$row['user']?>"></a>
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
	   <h1><a style='color:#800000' href="man.php?user=<?=$row['user']?>"><?=$row['user']?></a></h1>
	  </td>
	 </tr>
	<tr><td><?=$row['job']?></td></tr>
   </table>
  </div>
 </td>
</table>
<?}?>
           </div>
	      </div>
	     </div>
       </div>    
	  </div>
    <?require_once ("footer.php");?>
  </body>
</html>
