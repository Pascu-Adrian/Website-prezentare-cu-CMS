<?php
session_start();
$con=mysql_connect('localhost','nuntainc_root','gigihaios');
mysql_select_db('nuntainc_artdecomariaj');
if(isset($_GET['numetabel'])){
	$numetabel=$_GET['numetabel'];
	if(isset($_GET['fkey'])){
		$fkey=$_GET['fkey'];
		if(isset($_POST['adaugamaimulte'])){
			echo 'INTRODU FISIERUL IMAGINE(EXTENSIILE ACCEPTATE SUNT:<font color="red"><strong>png,gif,jpeg,jpg,bmp</strong></font>)<br/>
			SAU INTRODU ARHIVA CU IMAGINIE(TIPUL ARHIVEI ACCEPTATE ESTE: <font color="red"><strong>zip</strong></font>)
			<form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'?numetabel='.$numetabel.'&fkey='.$fkey.'" method="POST">
<label>FISIER:</label><input name="img" type="file" /><br/><input name="ok" type="submit" value="ADAUGA" />
</form>
<form action="index.php?categorie=galerie&numetabel='.$numetabel.'&fkey='.$fkey.'" method="POST">
<input name="anuleaza" type="submit" value="ANULEAZA">
</form>
';
		}
		elseif(isset($_POST['ok'])){
		
			if(isset($_FILES['img'])){
				$filename = $_FILES['img']['name'];
				$parts = explode('.',$filename);
				$extensie[]= end($parts);
				$sqlgetgalerie='SELECT id,nume FROM `pag-'.substr($numetabel, 4, strlen($numetabel)).'` WHERE id='.$fkey;
				$rezultatgetgalerie=mysql_query($sqlgetgalerie);
				while($rowgetgalerie=mysql_fetch_array($rezultatgetgalerie)){
				if($extensie[0]=='png'||$extensie[0]=='jpg'||$extensie[0]=='jpeg'||$extensie[0]=='bmp'||$extensie[0]=='gif'){				
					if(move_uploaded_file($_FILES['img']['tmp_name'], '../pag-'.substr($numetabel, 4, strlen($numetabel)).'/'.$rowgetgalerie['nume'].'/'.$filename)){
						
						$sqladauga='INSERT INTO `'.$numetabel.'` (id, nume,idcategorie,imagine,pozitie,activ) VALUES (\'NULL\', \''.$filename.'\',\''.$fkey.'\',\''.$filename.'\',\''.ultimapozitie($numetabel,$fkey).'\',\'1\')';
						//mysql_query($sqladauga);
						echo $sqladauga;
						
					} 
					echo '
			Imaginea a fost adaugata!
			<form enctype="multipart/form-data" action="index.php?categorie=galerie&numetabel='.$numetabel.'&fkey='.$fkey.'" method="post"><input name="ok" type="submit" value="OK"></form>
			';
				}
				elseif($extensie[0]=='zip'){
					cleandir('../uploadtemp/');
					
					if(move_uploaded_file($_FILES['img']['tmp_name'], '../uploadtemp/'.$filename)){
						dezarhiveaza('../uploadtemp/',$filename);
						adaugaimaginilagalerie($numetabel,$fkey,'../uploadtemp/');
						cleandir('../uploadtemp/');
							echo '
			Imaginile a fost adaugate!
			<form enctype="multipart/form-data" action="index.php?categorie=galerie&numetabel='.$numetabel.'&fkey='.$fkey.'" method="post"><input name="ok" type="submit" value="OK"></form>
			';
					}
					else
						echo '
			Imaginile nu au putut fi adaugate!
			<form enctype="multipart/form-data" action="index.php?categorie=galerie&numetabel='.$numetabel.'&fkey='.$fkey.'" method="post"><input name="ok" type="submit" value="OK"></form>
			';
					
				}
				else{
					echo '<font color="red"><strong>TIPUL FISIERULUI ESTE INVALID!</strong></font><br/>INTRODU FISIERUL IMAGINE(EXTENSIILE ACCEPTATE SUNT:<font color="red"><strong>png,gif,jpeg,jpg,bmp</strong></font>)<br/>
			SAU INTRODU ARHIVA CU IMAGINIE(TIPUL ARHIVEI ACCEPTATE ESTE: <font color="red"><strong>zip</strong></font>)
			<form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'?numetabel='.$numetabel.'&fkey='.$fkey.'" method="POST">
<label>FISIER:</label><input name="img" type="file" /><br/><input name="ok" type="submit" value="ADAUGA" />
</form>
<form action="index.php?categorie=galerie&numetabel='.$numetabel.'&fkey='.$fkey.'" method="POST">
<input name="anuleaza" type="submit" value="ANULEAZA">
</form>
';
				}
				}
			}
			else{
			echo 'INTRODU FISIERUL IMAGINE(EXTENSIILE ACCEPTATE SUNT:<font color="red"><strong>png,gif,jpeg,jpg,bmp</strong></font>)<br/>
			SAU INTRODU ARHIVA CU IMAGINIE(TIPUL ARHIVEI ACCEPTATE ESTE: <font color="red"><strong>zip</strong></font>)
			<form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'?numetabel='.$numetabel.'&fkey='.$fkey.'" method="POST">
<label>FISIER:</label><input name="img" type="file" /><br/><input name="ok" type="submit" value="ADAUGA" />
</form>
<form action="index.php?categorie=galerie&numetabel='.$numetabel.'&fkey='.$fkey.'" method="POST">
<input name="anuleaza" type="submit" value="ANULEAZA">
</form>
';
			}
			
		}
		else
			header ("Location: ".$_SERVER['HTTP_REFERER']);
	}
	else
		header ("Location: ".$_SERVER['HTTP_REFERER']);
}
else
	header ("Location: ".$_SERVER['HTTP_REFERER']);
	
	
	
	
	
	//-------------------------------------------------------------------
	
	
	
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


	
 function dezarhiveaza($director,$filename){
	 require_once('./pclzip.lib.php');
	 
	 $zip_dir = basename($filename, ".zip");
	 $archive = new PclZip($director.'/'.$filename);

	if ($archive->extract(PCLZIP_OPT_PATH, $director.'/') == 0)
		die("<font color='red'>Error : Unable to unzip archive</font>");
		unlink($director.'/'.$filename); //delete uploaded file
		dezarhiveazafisiere($director); 
 }
 
 
 
 
 function dezarhiveazafisiere($dir){
	 $dir_handle = @opendir($dir) or die("Unable to open $path");

     while (false !== ($file = readdir($dir_handle))) 
    {
		$parts=NULL;
		$extensie[]=NULL;
         if($file!="." && $file!="..")
         {
             if (is_dir($dir."/".$file))
             {
                 //Display a list of sub folders.
                 dezarhiveazafisiere($dir."/".$file);
				
             }
             else
             {
				 $parts = explode('.',$file);
					$extensie[0]= end($parts);
                if($extensie[0]=='zip'){
				dezarhiveaza($dir,$file);
				}
				else continue;
             }
         }
     }
     
    //closing the directory
     closedir($dir_handle);
 }

 function ultimapozitie($tabel,$fcheie){
	$sql1='SELECT * FROM `'.$tabel.'` WHERE idcategorie='.$fcheie.' ORDER BY pozitie ASC';
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

 
 function adaugaimaginilagalerie($numetabel,$fkey,$dir){
  $dir_handle = @opendir($dir) or die("Unable to open $dir");
     while (false !== ($file = readdir($dir_handle))) 
    {
		$parts=NULL;
		$extensie[]=NULL;
         if($file!="." && $file!="..")
         {
             if (is_dir($dir."/".$file))
             {
                 //Display a list of sub folders.
                 adaugaimaginilagalerie($numetabel,$fkey,$dir.'/'.$file);
				
             }
             else
             {
				 $numefisier=$file;
				 $parts = explode('.',$file);
					$extensie[0]= end($parts);
					
                if($extensie[0]=='png'||$extensie[0]=='jpg'||$extensie[0]=='jpeg'||$extensie[0]=='bmp'||$extensie[0]=='gif'){
					$sqlgetnumecategorie='SELECT id,nume FROM `pag-'.substr($numetabel, 4, strlen($numetabel)).'` WHERE id='.$fkey;
					$rezultatnumecategorie=mysql_query($sqlgetnumecategorie);
					while($rownumecategorie=mysql_fetch_array($rezultatnumecategorie)){
					if(file_exists('../pag-'.substr($numetabel, 4, strlen($numetabel)).'/'.$rownumecategorie['nume'].'/'.$file)){
						$asd=1;
						while(file_exists('../pag-'.substr($numetabel, 4, strlen($numetabel)).'/'.$rownumecategorie['nume'].'/'.$numefisier)){
								$numefisier=$asd.$numefisier;
								$asd++;
						}
						if (!copy($dir.'/'.$file, '../pag-'.substr($numetabel, 4, strlen($numetabel)).'/'.$rownumecategorie['nume'].'/'.$numefisier)) {
    								echo "failed to copy $file...\n";
								}
								else{
									$sqladaugaimagine='INSERT INTO `'.$numetabel.'` (id,nume,idcategorie,imagine,pozitie,activ)
 VALUES (\'\',\''.$numefisier.'\',\''.$fkey.'\',\''.$numefisier.'\',\''.ultimapozitie($numetabel,$fkey).'\',\'1\')';
 									mysql_query($sqladaugaimagine);
								}
					}
					else{
						if (!copy($dir.'/'.$file, '../pag-'.substr($numetabel, 4, strlen($numetabel)).'/'.$rownumecategorie['nume'].'/'.$numefisier)) {
    								echo "failed to copy $file...\n";
								}
								else{
									$sqladaugaimagine='INSERT INTO `'.$numetabel.'` (id,nume,idcategorie,imagine,pozitie,activ)
 VALUES (\'\',\''.$numefisier.'\',\''.$fkey.'\',\''.$numefisier.'\',\''.ultimapozitie($numetabel,$fkey).'\',\'1\')';
 									mysql_query($sqladaugaimagine);
								}	
					}
					}
				}
				
			 }
			 
		 }
		 
	}
 closedir($dir_handle);
 }
 
 mysql_close($con);
 ?>