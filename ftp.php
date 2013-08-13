<?require ("head.php");?>

<div class="ftp">
<script type="text/javascript">fadeOpacity.addRule('or2', .8, 1, 40);</script>

Files: <?
function get_dir($string) {
return preg_match("/(.)*(\.\.)|(2E%2E)(.)*/ui", $string); //%2F%2E%2E
}

if (isset($_GET['dir']) && get_dir($_GET['dir']))exit ("Invalid Input");
$dir = (isset($_GET['dir']) && !empty($_GET['dir'])) ? $_GET['dir'] : 'files';//to get
$d = './' . $dir . '/';//for local win
echo $dir;

$list=listdir_by_date($d);

foreach ($list as $p =>$file) {?>
  <div class='area' id='<?=$file?>' style="opacity:0.8;"  onMouseOver="fadeOpacity(this.id, 'or2')" onmouseout="fadeOpacity.back(this.id)">
	<?if (is_dir(iconv("utf-8", "cp1251", $d.$file))) { ?>
	  <a href="<?=$_SERVER['SCRIPT_NAME'].'?dir='.$dir.'/'.$file?>">
	    <img src="images/type/folder.png"><?=$file?>
	  </a>
	<?
	} else { 
	  $ras=pathinfo($file, PATHINFO_EXTENSION); 
	?>
	<a href='<?=$dir.'/'.$file?>'><img src='images/type/<?=$ras?>.png'><?=$file?></a>
	<?
	}
	?>
  </div>
  <?
}



function listdir_by_date($path){
	$path=iconv("utf-8", "cp1251", $path);
    $dir = opendir($path);
    $list = array();
    while($file = readdir($dir)){
        if ($file!= '.' and $file!= '..' and $file!= '.htaccess'){

            $ctime = filectime($path.$file) . ',' . $file . ',' . pathinfo($file, PATHINFO_EXTENSION);
							$file=iconv("cp1251", "utf-8", $file);

            $list[$ctime] = $file;
        }
    }
    closedir($dir);
    krsort($list);
    return $list;
}
//$list=listdir_by_date($d);
//echo "<pre>" ; print_r($list);
//$_SERVER['DOCUMENT_ROOT']
 
function dir_my_files(){
	$list = array();
	$ar1 = glob("C:/xampp/htdocs/files/*", GLOB_ONLYDIR + GLOB_MARK);
	$ar2 = glob("C:/xampp/htdocs/files/*.*");
	$list = array_merge($ar1, $ar2);
return $list;
}



//print_r(glob("C:/xampp/htdocs/files/*", GLOB_ONLYDIR + GLOB_MARK)); 
//print_r(glob("C:/xampp/htdocs/files/*.*"));
?> 
</div> <!--end ftp-->
           </div>
	      </div>
	     </div>
       </div>    
	  </div>
    <?require_once ("footer.php");?>
  </body>
</html>
