<?php include('./metadata.php');?>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <!-- HEADER -->
	<?php include('./header.php');?>
    <!-- END HEADER -->
    </td>
  </tr>
  <tr>
   <td colspan="3" align="center">
   <table width="989" border="0" cellspacing="0" cellpadding="0" style="background-image:url(images/body_background.png);margin-left:14px;background-position:center;">
  <tr>
    <td width="25%" align="left" valign="top" id="sitemapplace" class="sitemap">
    <!-- SITEMAP -->
  <?php include('./sitemap.php');?>
  	<!-- END SITEMAP -->
    </td>
    <td width="75%"  align="center">
    <!-- BODY -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;margin-bottom:20px;" align="center"> 

<?php
if(isset($_GET['categorie'])){
	$tabelnume=$_GET['categorie'];
	$sql='SELECT * FROM `datepagini` WHERE nume=\''.$tabelnume.'\'';
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		$tippagina=$row['tip'];
		
	if($tippagina=='lista'){
		
		$sql1='SELECT * FROM `pag-'.$tabelnume.'` WHERE activ=1 ORDER BY pozitie ASC';
$result1=mysql_query($sql1);
while($row1=mysql_fetch_array($result1)){
	if($row1['imagine']!=NULL){
		$sqlpozitieimagine='SELECT id,nume FROM pozitieimagine WHERE id='.$row1['pozitieimagine'];
		$resultpozitieimagine=mysql_query($sqlpozitieimagine);
		while($rowpozitieimagine=mysql_fetch_array($resultpozitieimagine)){
			$pozitieimagine=$rowpozitieimagine['nume'];
			if($pozitieimagine!=NULL){
				echo '<tr align="center"><td align="center">';		
				listaitem($row1['nume'],'./pag-'.$tabelnume.'/'.$row1['nume'].'/'.$row1['imagine'],$row1['text'],$pozitieimagine,$row1['pozitie']);
				echo '<br/></td></tr>';

			}
		}
		
	}
	
	else{
		echo '<tr align="center"><td align="center">';
		listaitem($row1['nume'],NULL,$row1['text'],'',$row1['pozitie']);
		echo '<br/></td></tr>';
	}
}
	}
	elseif($tippagina=='listaobiecte'){
		
			$sql='SELECT * FROM `pag-'.$tabelnume.'` WHERE activ=1 ORDER BY pozitie ASC';
			$result=mysql_query($sql);
			
			while($row=mysql_fetch_array($result)){
				echo '<tr><td>';
				echo'<table width="90%" border="0" cellspacing="1" cellpadding="3" bgcolor="#3399FF" align="center">
 				<tr>
    			<th scope="col" rowspan="2" align="left"><h1 id="sectiune'.$row['pozitie'].'"><font color="#FFFFFF"><strong><u>'.strtoupper($row['nume']).'</u></strong></font></h1></th>
    			<th scope="col" width="22%" align="right" valign="top"><div style="background-color:#00FFFF;height=20px;">';
				if($tabelnume!='contact')
				echo 'PRET: '.$row['pret'].' RON';
				echo '</div></th>
  				</tr>
				<tr>
				<th></th>
				</tr>';
				$sql1='SELECT * FROM `obj-'.$tabelnume.'` WHERE idcategorie=\''.$row['id'].'\' AND activ=1 ORDER BY pozitie ASC';
				$result1=mysql_query($sql1);
				$nrcrt=1;
				while($row1=mysql_fetch_array($result1)){
					echo'<tr><td style="background-color:#00FFFF;" colspan="2">';
					if($tabelnume!='contact')
					objectitem($row1['nume'],$row1['text'],$nrcrt);
					else{
						if($row1['nume']!=NULL)
						objectitem($row1['nume'].': '.$row1['text'],NULL,NULL);
						else
						objectitem($row1['text'],NULL,NULL);
					}
					echo '</tr></td>';
					$nrcrt++;
				}
				echo '</table>
				';
				echo '</td></tr><tr><td height="30px">&nbsp;</td></tr>';
				
			}
			
	}
	elseif($tippagina=='galerie'){
		if(isset($_GET['galerie'])){
			$sql='SELECT * FROM `pag-'.$tabelnume.'` WHERE nume=\''.$_GET['galerie'].'\' AND activ=1 ORDER BY pozitie ASC';
			$result=mysql_query($sql);
			while($row=mysql_fetch_array($result)){
				$sql1='SELECT * FROM `img-'.$tabelnume.'` WHERE idcategorie=\''.$row['id'].'\' AND activ=1 ORDER BY pozitie ASC';
			$result1=mysql_query($sql1);
			$count=1;
			while($row1=mysql_fetch_array($result1)){
				if($count==1)
					echo '<tr>';
				echo '<td>';
				galerieitem(strtoupper($tabelnume).'-=-'.$row['nume'],'./pag-'.$tabelnume.'/'.$row['nume'].'/'.$row1['imagine'],NULL);
				echo '</td>';
				if($count==4){
					echo '</tr>';
					$count=0;	
				}
				$count++;
			}
			}
		}
		else{
			$sql='SELECT * FROM `pag-'.$tabelnume.'` WHERE activ=1 ORDER BY pozitie ASC';
			$result=mysql_query($sql);	
			if(mysql_num_rows($result)>1)	{
				$count=1;
			while($row=mysql_fetch_array($result)){
				if($count==1)
					echo '<tr>';
				echo '<td>';
				galerieitem($row['nume'],'./pag-'.$tabelnume.'/'.$row['nume'].'/'.$row['imagine'],'pagina.php?categorie='.$tabelnume.'&galerie='.$row['nume']);
				echo '</td>';
				if($count==3){
					echo '</tr>';
					$count=0;	
				}
				$count++;
			}
			}
			elseif(mysql_num_rows($result)==1){
				while($row=mysql_fetch_array($result)){
					header('Location: pagina.php?categorie='.$tabelnume.'&galerie='.$row['nume']);
				}
				
			}
		}
	}
	}
}
else
	header('Location: index.php');
?>
  
</table>
<?php
if($tippagina=='galerie'){
		if(isset($_GET['galerie'])){
			echo '<div class="fb-comments" data-href="http://www.nuntainconstanta.ro'.$_SERVER["REQUEST_URI"].'" data-num-posts="3" data-width="470"></div>';
		}
}
?>
<br/> 
<!-- END BODY -->
    </td>
  </tr>
</table>
   </td>
  </tr>
  <tr>
    <td align="center">
    
    
    <!-- FOOTER -->
    <?php include('./footer.php')?>
    <!-- END FOOTER -->

<!-- FLOATMENU-->
<?php include('./floatmenu.php')?>
<!-- END FLOATMENU-->
</body>
</html>

<!-- functions -->

<?php
//----------------------------------------------------



?>