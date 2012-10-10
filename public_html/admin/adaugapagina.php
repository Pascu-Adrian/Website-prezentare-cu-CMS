<?php
session_start();
$con=mysql_connect('localhost','nuntainc_root','gigihaios');
mysql_select_db('nuntainc_artdecomariaj');



if(isset($_POST['adaugapagina'])){
	echo '
	COMPLETATI TOATE CAMPURILE CU DATELE NECESARE PENTRU A CREA PAGINA <br/><br/>
	<form action="adaugapagina.php" method="post">
	<label>NUME: </label><input name="nume" type="text"> Este folosit la: titlu, meniu, sitemap <br/>
	<label>DESCRIERE: </label><input name="descriere" type="text"> Descriere scurta a continutul paginii <br/>
	<label>CUVINTE CHEIE: </label><input name="cuvintecheie" type="text"> Cuvinte cheie referitoare la continutul paginii(se separa prin virgula) <br/>
	<label>TIPUL PAGINII: </label>
	<select name="tippagina">
	<option value="lista">TIP LISTA</option>
    <option value="listaobiecte">TIP LISTA OBIECTE</option>
	<option value="galerie">TIP GALERIE</option>
	</select><br/>
	<input name="ok" type="submit" value="ADAUGA PAGINA">
	</form>
	<form action="index.php?categorie=pagini" method="POST">
	<input name="anuleaza" type="submit" value="ANULEAZA">
	</form>
	';
}
elseif(isset($_POST['ok'])){
	if(isset($_POST['nume'])&&isset($_POST['descriere'])&&isset($_POST['cuvintecheie'])&&isset($_POST['tippagina'])&&$_POST['nume']!=NULL&&$_POST['descriere']!=NULL&&$_POST['cuvintecheie']!=NULL&&$_POST['tippagina']!=NULL){
		
		
		$nume=$_POST['nume'];
		$descriere=$_POST['descriere'];
		$cuvintecheie=$_POST['cuvintecheie'];
		$tippagina=$_POST['tippagina'];
		$exista=false;
		$sql = "SHOW TABLES FROM nuntainc_artdecomariaj";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_row($result)) {
					$numetabel=$row[0];	
					if($numetabel=='pag-'.$nume){
					$exista=true;
					break;	
					}
					else
						continue;
		}
		if(!$exista){
			
		if($tippagina=='lista'){
			
			$sql='CREATE TABLE `pag-'.$nume.'` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,`nume` VARCHAR( 50) NULL ,`text` TEXT NULL ,`imagine` VARCHAR( 250) NULL ,`pozitieimagine` INT NOT NULL ,`pozitie` INT NOT NULL ,`activ` INT NOT NULL DEFAULT\'1\',INDEX(`pozitieimagine`) ,UNIQUE (`nume`)) ENGINE= InnoDB';
 mysql_query($sql) or die('EROARE: '.mysql_error());
 
$sql='ALTER TABLE `pag-'.$nume.'` ADD FOREIGN KEY (`pozitieimagine` )REFERENCES `pozitieimagine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE ';
 mysql_query($sql) or die('EROARE: '.mysql_error());

mkdir('../pag-'.$nume,0777);
$sql = 'INSERT INTO `datepagini` (`id`, `nume`, `descriere`, `cuvintecheie`, `tip`) VALUES (NULL, \''.$nume.'\', \''.$descriere.'\', \''.$cuvintecheie.'\', \''.$tippagina.'\')';
mysql_query($sql) or die('EROARE: '.mysql_error());

			echo '
			PAGINA A FOST CREATA!
			</form>
	<form action="index.php?categorie=pagini" method="POST">
	<input name="continua" type="submit" value="OK">
	</form>
			';
		}
		elseif($tippagina=='listaobiecte'){
			$sql = 'CREATE TABLE `pag-'.$nume.'` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `nume` VARCHAR(50) NOT NULL, `pret` INT NULL, `pozitie` INT NOT NULL, `activ` INT NOT NULL DEFAULT \'1\', UNIQUE (`nume`)) ENGINE = InnoDB';
			mysql_query($sql) or die('EROARE: '.mysql_error());
			$sql = 'CREATE TABLE `obj-'.$nume.'` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `nume` VARCHAR(50) NOT NULL, `text` TEXT NULL, `idcategorie` INT NOT NULL, `pozitie` INT NOT NULL, `activ` INT NOT NULL DEFAULT \'1\', INDEX (`idcategorie`)) ENGINE = InnoDB';
			mysql_query($sql) or die('EROARE: '.mysql_error());
			
			$sql = 'ALTER TABLE `obj-'.$nume.'` ADD FOREIGN KEY (`idcategorie`) REFERENCES `pag-'.$nume.'`(`id`) ON DELETE CASCADE ON UPDATE CASCADE';
			mysql_query($sql) or die('EROARE: '.mysql_error());
					
mkdir('../pag-'.$nume,0777);
$sql = 'INSERT INTO `datepagini` (`id`, `nume`, `descriere`, `cuvintecheie`, `tip`) VALUES (NULL, \''.$nume.'\', \''.$descriere.'\', \''.$cuvintecheie.'\', \''.$tippagina.'\')';
mysql_query($sql) or die('EROARE: '.mysql_error());

			echo '
			PAGINA A FOST CREATA!
			</form>
	<form action="index.php?categorie=pagini" method="POST">
	<input name="continua" type="submit" value="OK">
	</form>
			';
		}
		elseif($tippagina=='galerie'){
			
			$sql = 'CREATE TABLE `pag-'.$nume.'` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `nume` VARCHAR(50) NOT NULL, `imagine` VARCHAR(250) NULL, `pozitie` INT NOT NULL, `activ` INT NOT NULL DEFAULT \'1\', UNIQUE (`nume`)) ENGINE = InnoDB';
			mysql_query($sql) or die('EROARE: '.mysql_error());
			
			$sql = 'CREATE TABLE `img-'.$nume.'` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `nume` INT NOT NULL, `idcategorie` INT NOT NULL, `imagine` VARCHAR(250) NOT NULL, `pozitie` INT NOT NULL, `activ` INT NOT NULL DEFAULT \'1\', INDEX (`idcategorie`)) ENGINE = InnoDB';
			mysql_query($sql) or die('EROARE: '.mysql_error());
			
			$sql = 'ALTER TABLE `img-'.$nume.'` ADD FOREIGN KEY (`idcategorie`) REFERENCES `pag-'.$nume.'`(`id`) ON DELETE CASCADE ON UPDATE CASCADE';
			mysql_query($sql) or die('EROARE: '.mysql_error());
			
			
mkdir('../pag-'.$nume,0777);
$sql = 'INSERT INTO `datepagini` (`id`, `nume`, `descriere`, `cuvintecheie`, `tip`) VALUES (NULL, \''.$nume.'\', \''.$descriere.'\', \''.$cuvintecheie.'\', \''.$tippagina.'\')';
mysql_query($sql) or die('EROARE: '.mysql_error());

			echo '
			PAGINA A FOST CREATA!
			</form>
	<form action="index.php?categorie=pagini" method="POST">
	<input name="continua" type="submit" value="OK">
	</form>
			';
		}
		}
		
		else{
			echo '
			PAGINA CU NUMELE '.$nume.' EXISTA DEJA!<br/>
	COMPLETATI TOATE CAMPURILE CU DATELE NECESARE PENTRU A CREA PAGINA <br/><br/>
	<form action="adaugapagina.php" method="post">
	<label>NUME: </label><input name="nume" type="text" value="';	
	echo '"> Este folosit la: titlu, meniu, sitemap <br/>
	<label>DESCRIERE: </label><input name="descriere" type="text" value="';
	
	if(isset($_POST['descriere']))
		echo $_POST['descriere'];
		
	echo '"> Descriere scurta a continutul paginii <br/>
	<label>CUVINTE CHEIE: </label><input name="cuvintecheie" type="text" value="';
	
	if(isset($_POST['cuvintecheie'])) echo $_POST['cuvintecheie'];

	echo '"> Cuvinte cheie referitoare la continutul paginii(se separa prin virgula) <br/>
	<label>TIPUL PAGINII: </label>
	<select name="tippagina">
	<option value="lista"';
	
	if(isset($_POST['tippagina'])&&$_POST['tippagina']=='lista') 
		echo 'selected';
	
	echo'>TIP LISTA</option>
    <option value="listaobiecte"';
	
	if(isset($_POST['tippagina'])&&$_POST['tippagina']=='listaobiecte') 
		echo 'selected';
		
	echo'>TIP LISTA OBIECTE</option>
	<option value="galerie"';
	
	if(isset($_POST['tippagina'])&&$_POST['tippagina']=='galerie') 
		echo 'selected';
	
	echo'>TIP GALERIE</option>
	</select><br/>
	<input name="ok" type="submit" value="ADAUGA PAGINA">
	</form>
	<form action="index.php?categorie=pagini" method="POST">
	<input name="anuleaza" type="submit" value="ANULEAZA">
	</form>
	';	
		}
		
		
	}
	else{
		echo '
	COMPLETATI TOATE CAMPURILE CU DATELE NECESARE PENTRU A CREA PAGINA <br/><br/>
	<form action="adaugapagina.php" method="post">
	<label>NUME: </label><input name="nume" type="text" value="';
	
	if(isset($_POST['nume']))
		echo $_POST['nume'];
		
	echo '"> Este folosit la: titlu, meniu, sitemap <br/>
	<label>DESCRIERE: </label><input name="descriere" type="text" value="';
	
	if(isset($_POST['descriere']))
		echo $_POST['descriere'];
		
	echo '"> Descriere scurta a continutul paginii <br/>
	<label>CUVINTE CHEIE: </label><input name="cuvintecheie" type="text" value="';
	
	if(isset($_POST['cuvintecheie'])) echo $_POST['cuvintecheie'];

	echo '"> Cuvinte cheie referitoare la continutul paginii(se separa prin virgula) <br/>
	<label>TIPUL PAGINII: </label>
	<select name="tippagina">
	<option value="lista"';
	
	if(isset($_POST['tippagina'])&&$_POST['tippagina']=='lista') 
		echo 'selected';
	
	echo'>TIP LISTA</option>
    <option value="listaobiecte"';
	
	if(isset($_POST['tippagina'])&&$_POST['tippagina']=='listaobiecte') 
		echo 'selected';
		
	echo'>TIP LISTA OBIECTE</option>
	<option value="galerie"';
	
	if(isset($_POST['tippagina'])&&$_POST['tippagina']=='galerie') 
		echo 'selected';
	
	echo'>TIP GALERIE</option>
	</select><br/>
	<input name="ok" type="submit" value="ADAUGA PAGINA">
	</form>
	<form action="index.php?categorie=pagini" method="POST">
	<input name="anuleaza" type="submit" value="ANULEAZA">
	</form>
	';
	}
}
else
	header ("Location: ".$_SERVER['HTTP_REFERER']);




mysql_close($con);
?>