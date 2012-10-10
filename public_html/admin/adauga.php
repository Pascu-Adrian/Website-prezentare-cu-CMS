<?php
session_start();
$con=mysql_connect('localhost','nuntainc_root','gigihaios');
mysql_select_db('nuntainc_artdecomariaj');

if(isset($_POST['adauga']))
    {
		if(isset($_GET['numetabel'])){
			$numetabel=$_GET['numetabel'];
			$sql='SHOW COLUMNS FROM `'.$numetabel.'`';
			$listacoloane = mysql_query($sql) or die("mysql error:".mysql_error());
			echo '<form action="adauga.php?numetabel='.$numetabel;
			if(isset($_GET['fkey']))
				echo '&fkey='.$_GET['fkey'];			
			echo '" method="post" enctype="multipart/form-data" name="data">';
			while($coloana=mysql_fetch_row($listacoloane)){
				if($coloana[0]=='id'){
					echo '<label>ID: </label><input name="id" type="text" value="NULL" size="10" readonly="true"><br/>';
				}
				if($coloana[0]=='nume'){
					echo '<label>NUME: </label><input name="nume" type="text" size="50"><br/>';
				}
				if($coloana[0]=='text'){
					echo '<label>TEXT: </label><textarea name="text" cols="100" rows="20"></textarea><br/>';
				}
				if($coloana[0]=='imagine'){
					echo '<label>IMAGINE: </label><input name="imagine" type="file" size="100"><br/>';
				}
				if($coloana[0]=='pozitieimagine'){
					$sqlquery="SELECT * FROM pozitieimagine";
					$sqlresult=mysql_query($sqlquery);
					echo '<label>POZITIE IMAGINE: </label>
					<select name="pozitieimagine">';
					
					while($getatr=mysql_fetch_array($sqlresult)){
						echo '<option value="'.$getatr['id'].'">'.$getatr['nume'].'</option>';
					}
					
					echo '</select><br/>';
				}
				if($coloana[0]=='pozitie'){
					
					if(isset($_GET['fkey'])){
						$fkey=$_GET['fkey'];
						$thequery='SELECT id FROM `'.$numetabel.'` WHERE idcategorie='.$fkey;
					}
					else
					$thequery='SELECT id FROM `'.$numetabel.'`';
					$result = mysql_query($thequery);
					$rows = mysql_num_rows($result);
					echo '<label>POZITIE: </label>
					<select name="pozitie">';
					for($i=1;$i<=$rows+1;$i++){
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
					echo '</select><br/>';
				}
				if($coloana[0]=='activ'){
						echo '<label>ACTIV:</label>
						<select name="activ">
                        <option value="1" selected>ACTIV</option>
                        <option value="0">INACTIV</option>
                        </select><br/>';
				}
				if($coloana[0]=='pret'){
					echo '<label>PRET: </label><input name="pret" type="text" size="30"><br/>';
					
				}
				if($coloana[0]=='idcategorie'){
					if(isset($_GET['fkey'])){
					echo '<label>IDCATEGORIE: </label><input name="idcategorie" type="text" size="2" value="'.$_GET['fkey'].'" redonly="readonly"><br/>';
						
					}
				}
				
				
			}
			echo '<input name="ok" type="submit" value="ADAUGA OBIECT" /></form><form action="'.$_SERVER['HTTP_REFERER'].'" method="post" enctype="multipart/form-data"><input name="anuleaza" type="submit" value="ANULEAZA" /></form>';
			
		}
	}
	elseif(isset($_POST['ok'])){
		$coloane="";
		$valori="";
		$numetabel=NULL;
		if(isset($_GET['numetabel'])){
			$numetabel=$_GET['numetabel'];
		}
				$pozitieveche='';
				$pozitienoua='';
				$sql='SHOW COLUMNS FROM `'.$numetabel.'`';
				$listacoloane = mysql_query($sql) or die("mysql error:".mysql_error());
				while($coloana=mysql_fetch_row($listacoloane)){
					
					if(isset($_POST[$coloana[0]])||isset($_FILES[$coloana[0]])){
						if($coloana[0]=='pozitie'){
							$coloane=$coloane.$coloana[0].',';
							$valori=$valori.'\''.(ultimapozitie($numetabel)+1).'\',';	
							$pozitieveche=ultimapozitie($numetabel)+1;
							$pozitienoua=$_POST[$coloana[0]];
						}
						elseif($coloana[0]=='imagine'){
							if(incepecu($numetabel,'img')){
								if(isset($_GET['fkey'])){
									$sqlgasestenumecategorie='SELECT id,nume FROM `pag-'.substr($numetabel, 4, strlen($numetabel)).'` WHERE id='.$_GET['fkey'];
									$rezultatnumecategorie=mysql_query($sqlgasestenumecategorie);
									while($getnumecategorie=mysql_fetch_array($rezultatnumecategorie)){
										if(!file_exists('../pag-'.substr($numetabel, 4, strlen($numetabel)).'/'.$getnumecategorie['nume'])){
									mkdir('../pag-'.substr($numetabel, 4, strlen($numetabel)).'/'.$getnumecategorie['nume'],0777);
								}
									}
								}
							}
							else{
							if(!file_exists('../'.$numetabel.'/'.$_POST['nume'])){
								if(!file_exists('../'.$numetabel)){
								mkdir('../'.$numetabel,0777);
								}
									mkdir('../'.$numetabel.'/'.$_POST['nume'],0777);
								}
							}
							if(isset($_FILES['imagine'])){
								$filename = $_FILES['imagine']['name'];
								$parts = explode('.',$filename);
								$extensie[]= end($parts);
						if($extensie[0]=='png'||$extensie[0]=='jpg'||$extensie[0]=='jpeg'||$extensie[0]=='bmp'||$extensie[0]=='gif'){
								if(isset($_GET['fkey'])){
									$sqlgasestenumecategorie='SELECT id,nume FROM `pag-'.substr($numetabel, 4, strlen($numetabel)).'` WHERE id='.$_GET['fkey'];
									$rezultatnumecategorie=mysql_query($sqlgasestenumecategorie);
									while($getnumecategorie=mysql_fetch_array($rezultatnumecategorie)){
									$i=1;
								while(file_exists('../pag-'.substr($numetabel, 4, strlen($numetabel)).'/'.$getnumecategorie['nume'].'/'.$filename)){
									$filename=$i.$filename;
									$i++;
								}
								
								if(move_uploaded_file($_FILES['imagine']['tmp_name'], '../pag-'.substr($numetabel, 4, strlen($numetabel)).'/'.$getnumecategorie['nume'].'/'.$filename)){
									$valori=$valori.'\''.$filename.'\',';
								}
								else
								$valori=$valori.'\''.''.'\',';
									}
								}
								
								
								
								
								
								//--
								else{
								$i=1;
								while(file_exists('../'.$numetabel.'/'.$_POST['nume'].'/'.$filename)){
									$filename=$i.$filename;
									$i++;
								}
								
								if(move_uploaded_file($_FILES['imagine']['tmp_name'], '../'.$numetabel.'/'.$_POST['nume'].'/'.$filename)){
									$valori=$valori.'\''.$filename.'\',';
								}
								else
								$valori=$valori.'\''.''.'\',';
								}
						}
						else
								$valori=$valori.'\''.''.'\',';
							}
							$coloane=$coloane.$coloana[0].',';
						}
						else{
						$coloane=$coloane.$coloana[0].',';
						$valori=$valori.'\''.$_POST[$coloana[0]].'\',';
						}
					}
				}
		$sql='INSERT INTO `'.$numetabel.'` ('.substr($coloane, 0, strlen($coloane)-1).') VALUES ('.substr($valori, 0, strlen($valori)-1).')';
		
		mysql_query($sql) or die(mysql_error());
		
		schimbapozitie($numetabel,$pozitieveche,$pozitienoua);
		if(incepecu($numetabel,'pag')){
					$categorie='pagini';
		echo 'AM ADAUGAT OBIECTUL!
					<form enctype="multipart/form-data" action="index.php?categorie='.$categorie.'&numetabel='.$numetabel.'" method="post"><input name="ok" type="submit" value="OK"></form>';
					}
elseif(incepecu($numetabel,'img')){
	if(isset($_GET['fkey']))
		$fkey=$_GET['fkey'];
					$categorie='galerie';
		echo 'AM ADAUGAT OBIECTUL!
					<form enctype="multipart/form-data" action="index.php?categorie='.$categorie.'&numetabel='.$numetabel.'&fkey='.$fkey.'" method="post"><input name="ok" type="submit" value="OK"></form>';
					}
elseif(incepecu($numetabel,'obj')){
	if(isset($_GET['fkey']))
		$fkey=$_GET['fkey'];
					$categorie='pagini';
		echo 'AM ADAUGAT OBIECTUL!
					<form enctype="multipart/form-data" action="index.php?categorie='.$categorie.'&numetabel='.$numetabel.'&fkey='.$fkey.'" method="post"><input name="ok" type="submit" value="OK"></form>';
					}
	}

//--------------------------------------------------------------------------------------------

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
	$pozitie=0;
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
 
 
 
 function existadirector($numedirector){
	if(file_exists('./'.$numedirector&&is_dir($numedirector)))
		return true;
	else
		return false;
}
?>