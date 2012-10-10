<?php
session_start();
$con=mysql_connect('localhost','nuntainc_root','gigihaios');
mysql_select_db('nuntainc_artdecomariaj');

if(isset($_POST['ok'])){
	$categorie='pagini';
	if(isset($_GET['numetabel'])&&existatabel($_GET['numetabel'])){
		$numetabel=$_GET['numetabel'];
		if(isset($_GET['id'])&&existaid($numetabel,$_GET['id'])){
			$id=$_GET['id'];
			if(areobiect($numetabel)&&!incepecu($numetabel,'obj')){
			$sql='DELETE FROM `obj-'.substr($numetabel, 4, strlen($numetabel)).'` WHERE idcategorie='.$id;	
			mysql_query($sql);
			}
			elseif(areimagine($numetabel)&&!incepecu($numetabel,'img')){
			$sql='DELETE FROM `img-'.substr($numetabel, 4, strlen($numetabel)).'` WHERE idcategorie='.$id;	
			mysql_query($sql);
			}
			$sql='SELECT nume,pozitie FROM `'.$numetabel.'` WHERE id='.$id;
					$result=mysql_query($sql);
					while($get=mysql_fetch_array($result)){	
							
						if(file_exists('../'.$numetabel.'/'.$get['nume'])){
							delete_directory('../'.$numetabel.'/'.$get['nume']);
						}
						schimbapozitie($numetabel,$get['pozitie'],ultimapozitie($numetabel));
					}
			$sql='DELETE FROM `'.$numetabel.'` WHERE id='.$id;	
			mysql_query($sql);
					echo 'AM STERS OBIECTUL!
					<form enctype="multipart/form-data" action="index.php?categorie='.$categorie.'&numetabel='.$numetabel;
						if(isset($_GET['fkeyp']))
							echo '&fkey='.$_GET['fkeyp'];
						echo'" method="post"><input name="ok" type="submit" value="OK"></form>';
		}
		elseif(isset($_GET['fkey'])){
			$fkey=$_GET['fkey'];
			$sql='SELECT nume,pozitie FROM `pag-'.substr($numetabel, 4, strlen($numetabel)).'` WHERE id='.$fkey;
					$result=mysql_query($sql);
					while($get=mysql_fetch_array($result)){			
						if(file_exists('../'.$numetabel.'/'.$get['nume']))
							delete_directory('../'.$numetabel.'/'.$get['nume']);
					}
			$sql='DELETE FROM `'.$numetabel.'` WHERE idcategorie='.$fkey;	
			mysql_query($sql);
			echo 'AM STERS OBIECTELE!
					<form enctype="multipart/form-data" action="index.php?categorie='.$categorie.'&numetabel='.$numetabel.'&fkey='.$fkey.'" method="post"><input name="ok" type="submit" value="OK"></form>';
			
		}
		else{
			if(areobiect($numetabel)&&!incepecu($numetabel,'obj')){
			$sql='DELETE FROM `obj-'.substr($numetabel, 4, strlen($numetabel));	
			mysql_query($sql);
			}
			elseif(areimagine($numetabel)&&!incepecu($numetabel,'img')){
			$sql='DELETE FROM `img-'.substr($numetabel, 4, strlen($numetabel));	
			mysql_query($sql);
			}		
						if(file_exists('../'.$numetabel))
							cleandir('../'.$numetabel);

			$sql='DELETE FROM `'.$numetabel.'`';	
			mysql_query($sql);
			echo 'AM STERS OBIECTELE!
					<form enctype="multipart/form-data" action="index.php?categorie='.$categorie.'&numetabel='.$numetabel;
						if(isset($_GET['fkeyp']))
							echo '&fkey='.$_GET['fkeyp'];
						echo'" method="post"><input name="ok" type="submit" value="OK"></form>';
		}
	}
	else
		header('Location: '.$_SERVER['HTTP_REFERER']);
}
elseif(isset($_POST['sterge'])){
	if(isset($_GET['numetabel'])&&existatabel($_GET['numetabel'])){
		$numetabel=$_GET['numetabel'];
		if(isset($_GET['id'])&&existaid($numetabel,$_GET['id'])){
			$id=$_GET['id'];
			$mesaj='SIGUR DORITI SA STERGETI OBIECTUL?<br/>';
			if(areobiect($numetabel)&&!incepecu($numetabel,'obj')){
			$mesaj='SIGUR DORITI SA STERGETI OBIECTUL? (OBIECTELE ATASATE VOR FI PERMANENT STERSE!)<br/>';
			}
			elseif(areimagine($numetabel)&&!incepecu($numetabel,'img')){
			$mesaj='SIGUR DORITI SA STERGETI OBIECTUL? (IMAGINILE ATASATE VOR FI PERMANENT STERSE!)<br/>';
			}
			echo $mesaj;
			echo '<form action="sterge.php?numetabel='.$numetabel.'&id='.$id;
						if(isset($_GET['fkeyp']))
							echo '&fkeyp='.$_GET['fkeyp'];
						echo'" method="post" enctype="multipart/form-data"><input name="ok" type="submit" value="STERGE" /></form><form action="'.$_SERVER['HTTP_REFERER'].'" method="post" enctype="multipart/form-data"><input name="anuleaza" type="submit" value="ANULEAZA" /></form>';
		}
		elseif(isset($_GET['fkey'])){
			$fkey=$_GET['fkey'];
			$mesaj='SIGUR DORITI SA STERGETI TOATE OBIECTELE?<br/>';
			echo $mesaj;
			echo '<form action="sterge.php?numetabel='.$numetabel.'&fkey='.$fkey.'" method="post" enctype="multipart/form-data"><input name="ok" type="submit" value="STERGE" /></form><form action="'.$_SERVER['HTTP_REFERER'].'" method="post" enctype="multipart/form-data"><input name="anuleaza" type="submit" value="ANULEAZA" /></form>';
			
		}
		else{
			$mesaj='SIGUR DORITI SA STERGETI TOATE OBIECTELE?<br/>';
			if(areobiect($numetabel)&&!incepecu($numetabel,'obj')){
			$mesaj='SIGUR DORITI SA STERGETI TOATE OBIECTELE? (OBIECTELE ATASATE VOR FI PERMANENT STERSE!)<br/>';
			}
			elseif(areimagine($numetabel)&&!incepecu($numetabel,'img')){
			$mesaj='SIGUR DORITI SA STERGETI TOATE OBIECTELE? (IMAGINILE ATASATE VOR FI PERMANENT STERSE!)<br/>';
			}			
			echo $mesaj;
			echo '<form action="sterge.php?numetabel='.$numetabel;
						if(isset($_GET['fkeyp']))
							echo '&fkey='.$_GET['fkeyp'];
						echo'" method="post" enctype="multipart/form-data"><input name="ok" type="submit" value="STERGE" /></form><form action="'.$_SERVER['HTTP_REFERER'].'" method="post" enctype="multipart/form-data"><input name="anuleaza" type="submit" value="ANULEAZA" /></form>';
		}
	}
	else
		header('Location: '.$_SERVER['HTTP_REFERER']);
}
else
	header('Location: '.$_SERVER['HTTP_REFERER']);

//--------------------------------------------------------------------------------------------------



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
function existaid($tabel,$id){
$sql='SELECT * FROM `'.$tabel.'` WHERE id='.$id;
$result=mysql_query($sql);
if(mysql_num_rows($result)>0)
	return true;
else
	return false;
}

function existadirector($numedirector){
	if(file_exists('./'.$numedirector&&is_dir($numedirector)))
		return true;
	else
		return false;
}

function cleandir($dirname)
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
 return true;
 }
 
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
 
 
 function incepecu($string,$prefix){
	for($i=0;$i<strlen($prefix);$i++){
		if($string[$i]==$prefix[$i]){
			continue;
		}
		else return false;
	}
	return true;
}

function ultimapozitie($tabel){
	$sql1='SELECT * FROM `'.$tabel.'` ORDER BY pozitie';
	$result1=mysql_query($sql1);
	$pozitie;
	if(mysql_num_rows($result1)>0){
		while($get=mysql_fetch_array($result1)){
			$pozitie=$get['pozitie'];
		}
		return $pozitie;
	}
	else 
		return $pozitie;
}

function schimbapozitie($tabel,$valoaredeschimbat,$valoarenoua){
	 $sqlquery="SELECT * FROM `".$tabel.'` ORDER BY pozitie ASC';
	 $rezultatsqlquery=mysql_query($sqlquery);
	 $gasit=false;
	 if($valoaredeschimbat>$valoarenoua){
			while($get=mysql_fetch_array($rezultatsqlquery)){
					if(!$gasit){
						if($get['pozitie']!=$valoarenoua){
							continue;
						}
											elseif($get['pozitie']==$valoarenoua){
												//increment
												$valoaretemp=$get['pozitie']+1;											
									$sqlmodif='UPDATE `'.$tabel.'` SET pozitie=\''.$valoaretemp.'\' WHERE `id`='.$get['id'];
                                				mysql_query($sqlmodif) or die("mysql error:".mysql_error());
												$gasit=true;
											}
										}
										elseif($gasit){
											if($get['pozitie']!=$valoaredeschimbat){
												//increment
												$valoaretemp=$get['pozitie']+1;											
									$sqlmodif='UPDATE `'.$tabel.'` SET pozitie=\''.$valoaretemp.'\' WHERE `id`='.$get['id'];
                                				mysql_query($sqlmodif) or die("mysql error:".mysql_error());
											}
											elseif($get['pozitie']==$valoaredeschimbat){
												//schimba
										$sqlmodif='UPDATE `'.$tabel.'` SET pozitie=\''.$valoarenoua.'\' WHERE `id`='.$get['id'];
                                				mysql_query($sqlmodif) or die("mysql error:".mysql_error());
												break;
											}
										}
									}
								}
								if($valoaredeschimbat<$valoarenoua){
									while($get=mysql_fetch_array($rezultatsqlquery)){
										if(!$gasit){
											if($get['pozitie']!=$valoaredeschimbat){
												continue;
											}
											elseif($get['pozitie']==$valoaredeschimbat){
									$sqlmodif='UPDATE `'.$tabel.'` SET pozitie=\''.$valoarenoua.'\' WHERE `id`='.$get['id'];
                                				mysql_query($sqlmodif) or die("mysql error:".mysql_error());
												$gasit=true;
											}
										}
										elseif($gasit){
											if($get['pozitie']!=$valoarenoua){
												//decrement
												$valoaretemp=$get['pozitie']-1;											
									$sqlmodif='UPDATE `'.$tabel.'` SET pozitie=\''.$valoaretemp.'\' WHERE `id`='.$get['id'];
                                				mysql_query($sqlmodif) or die("mysql error:".mysql_error());
											}
											elseif($get['pozitie']==$valoarenoua){
												//decrement
												$valoaretemp=$get['pozitie']-1;											
									$sqlmodif='UPDATE `'.$tabel.'` SET pozitie=\''.$valoaretemp.'\' WHERE `id`='.$get['id'];
                                				mysql_query($sqlmodif) or die("mysql error:".mysql_error());
												break;
											}
										}
									}
								}
 }
?>