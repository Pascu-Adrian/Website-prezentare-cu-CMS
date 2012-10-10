<?php
	$sql = "SHOW TABLES FROM nuntainc_artdecomariaj";
	$result = mysql_query($sql);
	echo '<ul>';
	while ($row = mysql_fetch_row($result)) {
			$numetabel=$row[0];	
			if(areimagine($numetabel)&&!incepecu($numetabel,'img-')){
				$sqlintern='SELECT id,nume FROM `'.$numetabel.'` WHERE activ=1 ORDER BY pozitie ASC';
				$resultintern=mysql_query($sqlintern);
				if(mysql_num_rows($resultintern)>1){
				echo '<li>';
				echo '<a href="pagina.php?categorie='.substr($numetabel, 4, strlen($numetabel)).'">'.strtoupper(substr($numetabel, 4, strlen($numetabel))).'</a>';
				}
				elseif(mysql_num_rows($resultintern)==1){
					echo '<li>';
					while($rowintern=mysql_fetch_array($resultintern)){
					echo '<a href="pagina.php?categorie='.substr($numetabel, 4, strlen($numetabel)).'&galerie='.$rowintern['nume'].'">'.strtoupper(substr($numetabel, 4, strlen($numetabel))).'</a>';
					echo '</li>';
				}
				}
				if(mysql_num_rows($resultintern)>1){
				echo '<ul>';
				while($rowintern=mysql_fetch_array($resultintern)){
					echo '<a href="pagina.php?categorie='.substr($numetabel, 4, strlen($numetabel)).'&galerie='.$rowintern['nume'].'"><li>'.$rowintern['nume'].'</li></a>';
				}
				echo '</ul>';
				echo '</li>';
				}
					
			}
			else
				continue;
	}
	$sql = "SHOW TABLES FROM nuntainc_artdecomariaj";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_row($result)) {
			$numetabel=$row[0];	
			if(areobiect($numetabel)&&!incepecu($numetabel,'obj-')&&$numetabel!='pag-contact'){
				echo '<li>';
				echo '<a href="pagina.php?categorie='.substr($numetabel, 4, strlen($numetabel)).'">'.strtoupper(substr($numetabel, 4, strlen($numetabel))).'</a>';;
				$sqlintern='SELECT * FROM `'.$numetabel.'` WHERE activ=1 ORDER BY pozitie ASC';
				$resultintern=mysql_query($sqlintern);
				if(mysql_num_rows($resultintern)>1){
				echo '<ul>';
				while($rowintern=mysql_fetch_array($resultintern)){
					echo '<a href="pagina.php?categorie='.substr($numetabel, 4, strlen($numetabel)).'#sectiune'.$rowintern['pozitie'].'"><li>'.$rowintern['nume'].'</li></a>';
				}
				echo '</ul>';
				}
				echo '</li>';	
			}
			else
				continue;
	}
	echo '</ul>';	
//-----------------------------------------------------------	

?>