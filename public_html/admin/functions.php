<?php
function listaitem($nume,$imagine,$text,$align,$pozitie){
	$width=150;
	$height=150;
	echo '<table width="90%" border="0" cellspacing="1" cellpadding="3" bgcolor="#5b7bb4">
  <tr>
    <th scope="col" colspan="2" align="left" bgcolor="#336699"><h3 id="sectiune'.$pozitie.'"><font color="#33CCFF"><strong>'.strtoupper($nume).'</strong></font></h3></th>
  </tr>
  <tr>';
  if($imagine!=NULL){
	  if($align=='stanga-sus'){
		 echo' <td align="left" width="'.$width.'" valign="top">
  		<img name="$imagine" src="'.$imagine.'" width="'.$width.'" height="'.$height.'" alt="ArtDecoMariaj '.$imagine.'" border="2">
 	 </td>
  	 <td align="left" valign="top"><font color="#FFFFFF">
  		'.$text.'
  	</font></td>';
	  }
	  elseif($align=='stanga-mijloc'){
		 echo' <td align="left" width="'.$width.'" valign="middle">
  		<img name="$imagine" src="'.$imagine.'" width="'.$width.'" height="'.$height.'" alt="ArtDecoMariaj '.$imagine.'" border="2">
 	 </td>
  	 <td align="left" valign="top"><font color="#FFFFFF">
  		'.$text.'
  	</font></td>';
	  }
	  elseif($align=='stanga-jos'){
		 echo' <td align="left" width="'.$width.'" valign="bottom">
  		<img name="$imagine" src="'.$imagine.'" width="'.$width.'" height="'.$height.'" alt="ArtDecoMariaj '.$imagine.'" border="2">
 	 </td>
  	 <td align="left" valign="top"><font color="#FFFFFF">
  		'.$text.'
  	</font></td>';
	  }
	  elseif($align=='dreapta-sus'){
		  echo '<td align="right" valign="top"><font color="#FFFFFF">
  		'.$text.'
 	 </font></td>
  	 <td align="right" width="'.$width.'" valign="top">
  		<img name="'.$imagine.'" src="'.$imagine.'" width="'.$width.'" height="'.$height.'" alt="ArtDecoMariaj '.$imagine.'" border="2"  bordercolor="#FFFFFF">
  	 </td>';
	  }
	  elseif($align=='dreapta-mijloc'){
		  echo '<td align="right" valign="top"><font color="#FFFFFF">
  		'.$text.'
 	 </font></td>
  	 <td align="right" width="'.$width.'" valign="middle">
  		<img name="'.$imagine.'" src="'.$imagine.'" width="'.$width.'" height="'.$height.'" alt="ArtDecoMariaj '.$imagine.'" border="2"  bordercolor="#FFFFFF">
  	 </td>';
	  }
	  elseif($align=='dreapta-jos'){
		  echo '<td align="right" valign="top"><font color="#FFFFFF">
  		'.$text.'
 	 </font></td>
  	 <td align="right" width="'.$width.'" valign="bottom">
  		<img name="'.$imagine.'" src="'.$imagine.'" width="'.$width.'" height="'.$height.'" alt="ArtDecoMariaj '.$imagine.'" border="2"  bordercolor="#FFFFFF">
  	 </td>';
	  }
  }
  else{
	echo '<td colspan="2" align="center" valign="top"><font color="#FFFFFF">
	'.$text.'
	</font></td> '; 
  }
 echo' </tr>
</table>';

}

function objectitem($nume,$text,$nrcrt){
	echo'
	<table width="100%" border="1" cellspacing="0" cellpadding="3" align="center" bordercolordark="#CCFFFF" bordercolorlight="#FFFFFF">
  <tr>';
  if($nrcrt!=NULL)
  echo '<th width="5%">'.$nrcrt.'</th>';
    echo '<th scope="col" align="left" bgcolor="#6699FF"><strong>'.strtoupper($nume).'</strong></th>
  </tr>';
  if($text!=NULL){
  echo'
  <tr>
    <td align="center" colspan="2">'.$text.'</td>
  </tr>';
  }
echo'
</table>
';
}
function galerieitem($nume,$imagine,$link){
		$width=150;
	$height=150;
	if($link!=NULL)
		echo '<a href="'.$link.'">';
		echo '
	<table width="100%" border="0" cellspacing="1" cellpadding="3" align="center">
  <tr><td scope="col" align="center">';
  if($link!=NULL)
    echo '<div style="width:200px;">'.strtoupper($nume).'</div>';
	echo '</td>
  </tr>
  <tr>
  	<td>';
	if($link==NULL)
	echo '<a href="'.$imagine.'" rel="lightbox['.$nume.']" title="ArtDecoMariaj -=- '.$nume.'"><img name="'.$imagine.'" src="'.$imagine.'" width="'.$width.'" height="'.$height.'" alt="ArtDecoMariaj '.$imagine.'" border="2"  bordercolor="#FFFFFF" style="background: white;"></a>';
	else
		echo '<img name="'.$imagine.'" src="'.$imagine.'" width="'.$width.'" height="'.$height.'" alt="ArtDecoMariaj '.$imagine.'" border="2"  bordercolor="#FFFFFF" style="background: white;">';
	echo '</td>
  </tr>
</table>';
if($link!=NULL)
		echo '</a>';

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
function seterminacu($string,$sufix){
	for($i=0;$i<strlen($sufix);$i++){
		if($string[strlen($string)-strlen($sufix)+$i]==$sufix[$i]){
			continue;
		}
		else return false;
	}
	return true;
}

?>