<?php
session_start();
$con=mysql_connect('localhost','nuntainc_root','gigihaios');
mysql_select_db('nuntainc_artdecomariaj');
if(isset($_GET['numetabel'])){
	$numetabel=$_GET['numetabel'];
	if(isset($_GET['fkey'])){
		$fkey=$_GET['fkey'];
		if(isset($_POST['stergeselectate'])){
			if(isset($_POST['sterge'])){
				$desters=$_POST['sterge'];
				foreach($desters as $iddesters){					
					$query2='SELECT id,nume FROM `pag-'.substr($numetabel, 4, strlen($numetabel)).'` WHERE id='.$fkey;
					$result2=mysql_query($query2);
					while($row2=mysql_fetch_array($result2)){
						$query='SELECT id,imagine FROM `'.$numetabel.'` WHERE id='.$iddesters;
						$result=mysql_query($query);
						echo mysql_num_rows($result);
						while($row=mysql_fetch_array($result)){
					if(file_exists('../pag-'.substr($numetabel, 4, strlen($numetabel)).'/'.$row2['nume'].'/'.$row['imagine'])){	
						unlink('../pag-'.substr($numetabel, 4, strlen($numetabel)).'/'.$row2['nume'].'/'.$row['imagine']);
					}
					else
						continue;
						}
					}
					$sql='DELETE FROM `'.$numetabel.'` WHERE id='.$iddesters;
					mysql_query($sql);
				}
							echo '
			Obiectele au fost sterse!
			<form enctype="multipart/form-data" action="index.php?categorie=galerie&numetabel='.$numetabel.'&fkey='.$fkey.'" method="post"><input name="ok" type="submit" value="OK"></form>
			';
			}
			else
			echo '
			Selectati cel putin un obiect pentru a fi sters!
			<form enctype="multipart/form-data" action="index.php?categorie=galerie&numetabel='.$numetabel.'&fkey='.$fkey.'" method="post"><input name="ok" type="submit" value="OK"></form>
			';
		}
		elseif(isset($_POST['salveazasetari'])){
			if(isset($_POST['activ'])){
				$activ=$_POST['activ'];
				$getallquery='SELECT id,nume FROM `'.$numetabel.'` WHERE idcategorie='.$fkey;
				$getallresult=mysql_query($getallquery);
				$sql='UPDATE `'.$numetabel.'` SET activ=0 WHERE idcategorie='.$fkey;
							mysql_query($sql);
				while($getrow=mysql_fetch_array($getallresult)){
				foreach($activ as $idactiv){
					if($idactiv==$getrow['id']){
						$sql='UPDATE `'.$numetabel.'` SET activ=1 WHERE id='.$idactiv;
							mysql_query($sql);
							break;
						}			
				}
				}
				
			}
			else{
				$sql='UPDATE `'.$numetabel.'` SET activ=0 WHERE idcategorie='.$fkey;
							mysql_query($sql);	
			}
			echo '
			Setarile s-au salvat!
			<form enctype="multipart/form-data" action="index.php?categorie=galerie&numetabel='.$numetabel.'&fkey='.$fkey.'" method="post"><input name="ok" type="submit" value="OK"></form>
			';
		}
		else{
			header ("Location: ".$_SERVER['HTTP_REFERER']);
		}
	}//fkey
	else
		header ("Location: ".$_SERVER['HTTP_REFERER']);
}//numetabel
else
	header ("Location: ".$_SERVER['HTTP_REFERER']);


?>