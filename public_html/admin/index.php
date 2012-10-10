<?php
session_start();
if(isset($_SESSION['username'])){
	require('./functions.php');
$con=mysql_connect('localhost','nuntainc_root','gigihaios');
mysql_select_db('nuntainc_artdecomariaj');
if(isset($_GET['categorie'])){	
	$categorie=$_GET['categorie'];
	if($categorie=='pagini'){
		
		if(isset($_GET['numetabel'])){
			$numetabel=$_GET['numetabel'];
			$sql='SHOW COLUMNS FROM `'.$numetabel.'`';
			$listacoloane = mysql_query($sql) or die("mysql error:".mysql_error());
			if(isset($_GET['fkey'])){
				$fkey=$_GET['fkey'];
				$sql1='SELECT * FROM `'.$numetabel.'` WHERE idcategorie='.$fkey.' ORDER BY `pozitie` ASC';
			}
			else
			$sql1='SELECT * FROM `'.$numetabel.'` ORDER BY `pozitie` ASC';	
			$result = mysql_query($sql1) or die("mysql error:".mysql_error());
			echo'<a href="index.php?categorie='.$categorie;
			if(isset($_GET['fkey']))
				echo '&numetabel=pag-'.substr($numetabel, 4, strlen($numetabel));
			echo '"><h3>INAPOI</h3></a><br/>
			<a href="logout.php">LOGOUT</a>
			<form action="adauga.php?numetabel='.$numetabel;
			if(isset($_GET['fkey']))
				echo '&fkey='.$fkey;
			echo '" method="post"><input name="adauga" type="submit" value="ADAUGA OBIECT NOU"></form>
			<form action="sterge.php?numetabel='.$numetabel;
			if(isset($_GET['fkey']))
				echo '&fkey='.$_GET['fkey'];
			echo '" method="post"><input name="sterge" type="submit" value="STERGE TOATE OBIECTELE"></form>';
			
			if(isset($_GET['fkey'])){
				$fkey=$_GET['fkey'];
				$query='SELECT nume FROM `pag-'.substr($numetabel, 4, strlen($numetabel)).'` WHERE id='.$fkey;
				$qr=mysql_query($query);
				while($g=mysql_fetch_array($qr)){
					echo '<h1><b>'.$g['nume'].'</b></h1><br/>';
				}
			}
			else
				echo '<h1><strong>'.strtoupper(substr($numetabel, 4, strlen($numetabel))).'</strong></h1><br/>';
			
			echo '<table width="100%" border="1">
			<tr>
			';
			while($coloana=mysql_fetch_row($listacoloane)){
				if($coloana[0]=='idcategorie')
					continue;
				
				else
					echo '<th scope="col">'.strtoupper($coloana[0]).'</th>';
			}
			echo '<th scope="col">INSTRUMENTE</th></tr>';
			if(mysql_num_rows($result)>0){
			while($get=mysql_fetch_array($result)){
				echo '<tr>';
				$sql2='SHOW COLUMNS FROM `'.$numetabel.'`';
				$listacoloane1 = mysql_query($sql2) or die("mysql error:".mysql_error());
				while($coloana1=mysql_fetch_row($listacoloane1)){
					if($coloana1[0]=='idcategorie')
						continue;
				
					if($coloana1[0]=='id'){
						echo '<td align="center">'.$get[$coloana1[0]].'</td>';
					}
					if($coloana1[0]=='nume'){
						echo '<td align="center">'.$get[$coloana1[0]].'<br/>
						<form action="schimba.php?numetabel='.$numetabel.'&coloana='.$coloana1[0].'&id='.$get['id'];
						if(isset($_GET['fkey']))
							echo '&fkey='.$_GET['fkey'];
						echo'" method="post"><input name="schimba" type="submit" value="SCHIMBA '.strtoupper($coloana1[0]).'"></form>
						</td>';
					}
					if($coloana1[0]=='text'){
						echo '<td align="center"><textarea name="" cols="20" rows="10" readonly="readonly">'.$get[$coloana1[0]].'</textarea>
						<br/>
						<form action="schimba.php?numetabel='.$numetabel.'&coloana='.$coloana1[0].'&id='.$get['id'];
						if(isset($_GET['fkey']))
							echo '&fkey='.$_GET['fkey'];
						echo'" method="post"><input name="schimba" type="submit" value="SCHIMBA '.strtoupper($coloana1[0]).'"></form>
						</td>';
					}
					if($coloana1[0]=='imagine'){
						$numefolder=$get['nume'];
						if(isset($_GET['fkey'])){
							$thenewsql='SELECT id,nume FROM `pag-'.substr($numetabel, 4, strlen($numetabel)).'` WHERE id='.$_GET['fkey'];
							$thenewresult=mysql_query($thenewsql);
							while($thenewrow=mysql_fetch_array($thenewresult)){
								$numefolder=$thenewrow['nume'];	
							}
						}
						
						
						echo '<td align="center"><img src="../pag-'.substr($numetabel, 4, strlen($numetabel)).'/'.$numefolder.'/'.$get[$coloana1[0]].'" height="150px" width="150px">
						<br/>
						<form action="schimba.php?numetabel='.$numetabel.'&coloana='.$coloana1[0].'&id='.$get['id'];
						if(isset($_GET['fkey']))
							echo '&fkey='.$_GET['fkey'];
						echo'" method="post"><input name="schimba" type="submit" value="SCHIMBA '.strtoupper($coloana1[0]).'"></form>
						</td>';
					}
					if($coloana1[0]=='pozitieimagine'){
						$sqlqueryselect='SELECT * FROM pozitieimagine WHERE id='.$get[$coloana1[0]];
						$sqlqueryresult=mysql_query($sqlqueryselect);
						while($getresult=mysql_fetch_array($sqlqueryresult)){
						echo '<td align="center">'.$getresult['nume'];
						}
						echo '
						<br/>
						<form action="schimba.php?numetabel='.$numetabel.'&coloana='.$coloana1[0].'&id='.$get['id'];
						if(isset($_GET['fkey']))
							echo '&fkey='.$_GET['fkey'];
						echo'" method="post"><input name="schimba" type="submit" value="SCHIMBA '.strtoupper($coloana1[0]).'"></form>
						</td>';
					}
					if($coloana1[0]=='pozitie'){
						echo '<td align="center">'.$get[$coloana1[0]].'
						<br/>
						<form action="schimba.php?numetabel='.$numetabel.'&coloana='.$coloana1[0].'&id='.$get['id'];
						if(isset($_GET['fkey']))
							echo '&fkey='.$_GET['fkey'];
						echo '" method="post"><input name="schimba" type="submit" value="SCHIMBA '.strtoupper($coloana1[0]).'"></form>
						</td>';
					}
					if($coloana1[0]=='activ'){
						echo '<td align="center">';
						if($get[$coloana1[0]]==1)	
							echo 'ACTIV';
						elseif($get[$coloana1[0]]==0)
							echo 'INACTIV';
						echo '
						<br/>
						<form action="schimba.php?numetabel='.$numetabel.'&coloana='.$coloana1[0].'&id='.$get['id'];
						if(isset($_GET['fkey']))
							echo '&fkey='.$_GET['fkey'];
						echo'" method="post"><input name="schimba" type="submit" value="SCHIMBA '.strtoupper($coloana1[0]).'"></form>
						</td>';
					}
					if($coloana1[0]=='pret'){
						echo '<td align="center">'.$get[$coloana1[0]].'
						<br/>
						<form action="schimba.php?numetabel='.$numetabel.'&coloana='.$coloana1[0].'&id='.$get['id'];
						if(isset($_GET['fkey']))
							echo '&fkey='.$_GET['fkey'];
						echo'" method="post"><input name="schimba" type="submit" value="SCHIMBA '.strtoupper($coloana1[0]).'"></form>
						</td>';
					}			
				}
				echo '
				<td align="center">
				<form action="sterge.php?numetabel='.$numetabel.'&id='.$get['id'];
						if(isset($_GET['fkey']))
							echo '&fkeyp='.$_GET['fkey'];
						echo'" method="post"><input name="sterge" type="submit" value="STERGE"></form>';
				if(areobiect($numetabel)&&!incepecu($numetabel,'obj')){
					echo '
				<form action="index.php?categorie=pagini&numetabel=obj-'.substr($numetabel, 4, strlen($numetabel)).'&fkey='.$get['id'].'" method="post"><input name="modifica" type="submit" value="MODIFICA"></form>';
				}
				elseif(areimagine($numetabel)&&!incepecu($numetabel,'img')){
					echo '
					<form action="index.php?categorie=pagini&numetabel=img-'.substr($numetabel, 4, strlen($numetabel)).'&fkey='.$get['id'].'" method="post"><input name="modifica" type="submit" value="MODIFICA CA OBIECTE"></form>
				<form action="index.php?categorie=galerie&numetabel=img-'.substr($numetabel, 4, strlen($numetabel)).'&fkey='.$get['id'].'" method="post"><input name="modifica" type="submit" value="MODIFICA CA GALERIE"></form>';
				}
				echo '
				</td>
				</tr>';
			}
			}
  			echo'
			</table>
			';
    		
  			mysql_free_result($result);

		}
		else{
			$sql = "SHOW TABLES FROM nuntainc_artdecomariaj";
			$result = mysql_query($sql);

			if (!$result) {
    			echo "EROARE BAZA DE DATE, NU AM PUTUT LISTA TABELELE\n";
				echo "CONTACTEAZA PE ADI!\n";
    			echo 'MySQL Error: ' . mysql_error();
			}
			else{
				
				echo'<a href="index.php"><h3>INAPOI</h3></a><br/>
				<a href="logout.php">LOGOUT</a>
				<form action="adaugapagina.php" method="post" enctype="multipart/form-data"><input name="adaugapagina" type="submit" value="ADAUGA PAGINA NOUA"/></form>
				<form action="stergepagini.php" method="post">
				<input name="stergeselectate" type="submit" value="STERGE PAGINILE SELECTATE"/>
				';			
				
				echo'
				<table border="1" align="center">
  				<tr>
    			<td><table width="100%" border="1">
  				<tr>';
    			while ($row = mysql_fetch_row($result)) {
					$numetabel=$row[0];	
					if(incepecu($numetabel,'pag')&&$numetabel!='pag-banner'){
				echo'<td><a href="index.php?categorie='.$categorie.'&numetabel='.$numetabel.'">'.strtoupper(substr($numetabel, 4, strlen($numetabel))).'</a><input name="desters[]" type="checkbox" value="'.$numetabel.'" /></td>';
					}
    			}
 				echo'
				</tr>
				</form>
				</table>
				</td>
  				</tr>
				</table>';
				mysql_free_result($result);
				
			}
		}
		
	}
	
	if($categorie=='instrumente'){
		
	}
	
	if($categorie=='user'){
		
	}
	if($categorie=='galerie'){
		if(isset($_GET['numetabel'])){
			$numetabel=$_GET['numetabel'];
		if(isset($_GET['fkey'])){
				$fkey=$_GET['fkey'];
				$sql='SELECT * FROM `'.$numetabel.'` WHERE idcategorie='.$fkey.' ORDER BY `pozitie` ASC';	
			$result = mysql_query($sql) or die("mysql error:".mysql_error());
			echo'<a href="index.php?categorie=pagini&numetabel=pag-'.substr($numetabel, 4, strlen($numetabel)).'"><h3>INAPOI</h3></a><br/>
			<a href="logout.php">LOGOUT</a>
			<form action="adauga.php?numetabel='.$numetabel.'&fkey='.$fkey.'" method="post"><input name="adauga" type="submit" value="ADAUGA OBIECT NOU"></form>
			<form action="sterge.php?numetabel='.$numetabel.'&fkey='.$_GET['fkey'].'" method="post"><input name="sterge" type="submit" value="STERGE TOATE OBIECTELE"></form>';
				$query='SELECT nume FROM `pag-'.substr($numetabel, 4, strlen($numetabel)).'` WHERE id='.$fkey;
				$qr=mysql_query($query);
				while($g=mysql_fetch_array($qr))
					echo '<h1><b>'.$g['nume'].'</b></h1><br/>';
					
					
					
					//------------------------------de aici incepe pe bune administrarea galerie
					echo '<form action="adaugamaimultetipgalerie.php?numetabel='.$numetabel.'&fkey='.$fkey.'" method="post" enctype="multipart/form-data">
					<input name="adaugamaimulte" type="submit" value="ADAUGA MAI MULTE POZE">
					</form>
					<form action="schimbatipgalerie.php?numetabel='.$numetabel.'&fkey='.$fkey.'" method="post" enctype="multipart/form-data" name="input">
					<input name="stergeselectate" type="submit" value="STERGE SELECTATE">
					<label>ACTIVEAZA TOATE: </label><input name="toate" type="checkbox" value="toate" onclick="checkAll();"/><br/>
					<input name="salveazasetari" type="submit" value="SALVEAZA SETARI"><br/>';
					$sqlqueryimagini='SELECT * FROM `'.$numetabel.'` WHERE idcategorie='.$fkey;
					$rezultatimagini=mysql_query($sqlqueryimagini);
					$sqlcategorie='SELECT id,nume FROM `pag-'.substr($numetabel, 4, strlen($numetabel)).'` WHERE id='.$fkey;
					$rezultatcategorie=mysql_query($sqlcategorie);
					$numecategorie='';
					while($rowcategorie=mysql_fetch_array($rezultatcategorie)){
						$numecategorie=$rowcategorie['nume'];
					}
					$count=1;
					echo '<table cellpadding="10" cellspacing="10" border="1" align="center">';
					while($rowimagine=mysql_fetch_array($rezultatimagini)){
						if($count==1)
							echo '<tr>';
						echo '<td align="center">NUME: '.$rowimagine['nume'].'<br/>';
						echo '<img src="../pag-'.substr($numetabel, 4, strlen($numetabel)).'/'.$numecategorie.'/'.$rowimagine['imagine'].'" height="170px" width="170px"><br/>';
						if($rowimagine['activ']==1)
							echo 'ACTIV: <input id="activ" name="activ[]" type="checkbox" value="'.$rowimagine['id'].'" checked><br/>';
						else	
							echo 'ACTIV: <input id="activ" name="activ[]" type="checkbox" value="'.$rowimagine['id'].'"><br/>';
						echo 'DE STERS: <input id="desters" name="sterge[]" type="checkbox" value="'.$rowimagine['id'].'"><br/></td>';
						
						if($count==5){
							echo '</tr>';
							$count=0;	
						}
						$count++;
						
					}
					echo '</table>';
					
					/*<table width="100%" border="1">
  						<tr>
   							<td>&nbsp;</td>
  						</tr>
					</table>*/

					
					echo '</form>';
					
					
		}
		else
			header('Location: index.php');
		}
		else
			header('Location: index.php');
	}
	if($categorie!='user'&&$categorie!='pagini'&&$categorie!='instrumente'&&$categorie!='galerie')
		header('Location: index.php');

}
else{
	//    <td><a href="index.php?categorie=instrumente">INTRUMENTE</a></td>
    //<td><a href="index.php?categorie=user">USER</a></td>
	echo '
	<table border="1" align="center">
  <tr>
    <td><table width="100%" border="1">
  <tr>
    <td><a href="index.php?categorie=pagini">PAGINI</a></td>
	<td><a href="index.php?categorie=pagini&numetabel=pag-banner">BANNER</a></td>
  </tr>
</table>
</td>
  </tr>
</table>
';
}
mysql_close($con);
}

else
echo '
<table width="200px" id="loginform" align="center" valign="middle">
    <form action="login.php" method="post">
  <tr>
    <td ><label>Utilizator:</label></td>
    <td ><input name="username" type="text" size="20" class="inputloginform"/></td>
  </tr>
  <tr>
    <td><label>Parola:</label></td>
    <td><input name="password" type="password" size="20" class="inputloginform"/></td>
  </tr>
  <tr>
    <td align="center"><input name="login" type="submit" value="Logheaza-ma" /></td>
  </tr></form>
</table>
';
?>
<script type="text/javascript">
function checkAll()
{
	var chestie=document.getElementsByTagName('input');
	for(var j=0;j<chestie.length;j++){
	if(chestie.item(j).getAttribute('type')=='checkbox'&&chestie.item(j).getAttribute('name')!='toate'&&chestie.item(j).getAttribute('id')!='desters'){
		if(document.input.toate.checked==true){
		chestie.item(j).checked=true;
		}
		if(document.input.toate.checked==false){
		chestie.item(j).checked=false;
		}
	}
	else continue;
	}
}
 
</script>
