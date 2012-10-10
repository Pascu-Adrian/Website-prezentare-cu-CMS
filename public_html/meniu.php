<?php
$sqltabele='SHOW TABLES FROM nuntainc_artdecomariaj';
$listatabele=mysql_query($sqltabele);
echo '<a href="pagina.php?categorie=acasa">ACASA</a> | ';
while ($rowtabele = mysql_fetch_row($listatabele)) {
	if(incepecu($rowtabele[0],'pag')&&$rowtabele[0]!='pag-acasa'&&$rowtabele[0]!='pag-contact'&&$rowtabele[0]!='pag-banner'&&$rowtabele[0]!='pag-servicii'){
		$sqlintern='SELECT id,nume FROM `'.$rowtabele[0].'` WHERE activ=1 ORDER BY pozitie ASC';
				$resultintern=mysql_query($sqlintern);
				if(mysql_num_rows($resultintern)==1&&areimagine($rowtabele[0])){
					while($rowintern=mysql_fetch_array($resultintern)){
   echo '<a href="pagina.php?categorie='.substr($rowtabele[0], 4, strlen($rowtabele[0])).'&galerie='.$rowintern['nume'].'">'.strtoupper(substr($rowtabele[0], 4, strlen($rowtabele[0]))).'</a> | ';
					}
				}
				else
					echo '<a href="pagina.php?categorie='.substr($rowtabele[0], 4, strlen($rowtabele[0])).'">'.strtoupper(substr($rowtabele[0], 4, strlen($rowtabele[0]))).'</a> | ';
	}
	else continue;
}
echo '<a href="pagina.php?categorie=contact">CONTACT </a>| ';

//--------------------------------

?>