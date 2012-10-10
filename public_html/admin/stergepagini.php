<?php
session_start();
$con=mysql_connect('localhost','nuntainc_root','gigihaios');
mysql_select_db('nuntainc_artdecomariaj');


if(isset($_POST['stergeselectate'])){
	if(isset($_POST['desters'])){
		$lista=$_POST['desters'];
		if(sizeof($lista)>0){
			for($i=0;$i<sizeof($lista);$i++){
				if($lista[$i]!='pag-contact'&&$lista[$i]!='pag-acasa'){
					if(areobiect($lista[$i])){
						$sql = 'DROP TABLE `obj-'.substr($lista[$i], 4, strlen($lista[$i])).'`';
						mysql_query($sql) or die('EROARE: '.mysql_error());
					}
					if(areimagine($lista[$i])){
						$sql = 'DROP TABLE `img-'.substr($lista[$i], 4, strlen($lista[$i])).'`';
						mysql_query($sql) or die('EROARE: '.mysql_error());
					}
						
					if(file_exists('../'.$lista[$i])&&is_dir('../'.$lista[$i])){
						delete_directory('../'.$lista[$i]);
					}
						$sql = 'DROP TABLE `'.$lista[$i].'`';
						mysql_query($sql) or die('EROARE: '.mysql_error());
						
						$sql='DELETE FROM `datepagini` WHERE nume=\''.substr($lista[$i], 4, strlen($lista[$i])).'\'';
						mysql_query($sql) or die('EROARE: '.mysql_error());
				}
				else
					continue;
			}
			echo '
			AM STERS PAGINILE SELECTATE SI DATELE LOR!<br/>
			<form action="index.php?categorie=pagini" method="POST">
	<input name="continua" type="submit" value="OK">
	</form>';
		}
		else
			header('Location: index.php?categorie=pagini');
	}
	else
		header('Location: index.php?categorie=pagini');
}
else
	header('Location: index.php?categorie=pagini');



//--------------------------------------------------------

function delete_directory($dirname)
 {
 if (is_dir($dirname))
 $dir_handle = opendir($dirname);
 if (!$dir_handle)
 return false;
 while($file = readdir($dir_handle)) {
 if ($file != "." && $file != "..") {
if (!is_dir($dirname."/".$file))
 unlink($dirname."/".$file);
 else
 delete_directory($dirname.'/'.$file);
 }
 }
 closedir($dir_handle);
 rmdir($dirname);
 return true;
 }
function areobiect($tabel){
	if(existatabel('obj-'.substr($tabel, 4, strlen($tabel)))){
		return true;
	}
	else
		return false;
}
function areimagine($tabel){
	if(existatabel('img-'.substr($tabel, 4, strlen($tabel)))){
		return true;
	}
	else
		return false;
}
function existatabel($tabel){
	$sql= 'DESC `'.$tabel.'`;'; 
	 mysql_query($sql);
	 if (mysql_errno()==1146)
	 	return false;          
	elseif (!mysql_errno())      
		return true;		          
}
?>