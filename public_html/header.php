<div style="position: absolute; top:0; left:0"><font color="#FFFFFF" size="-6">ArtDecoMariaj - decoratiuni nunti constanta, aranjamente nunti constanta, aranjamente mese festive constanta, decoratiuni botez constanta, aranjamente botezuri constanta, decoratiuni evenimente, fatana de ciocolata, fantana sampanie, sculpturi de fructe, aranjamente, decoratiuni</font></div>
<table width="989" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>

    <td colspan="2" align="center" height="90px">
    <!-- LOGO -->
    <a href="pagina.php?categorie=acasa"><img src="./images/logo.png" width="400" height="74" alt="LOGO" style="border:hidden;"/></a></td>
 
  </tr>
  <tr>
    <td height="63" colspan="2" align="right" valign="middle" class="meniu">
    <!-- MENU -->
    <?php include('./meniu.php');?>
	<!-- END MENU -->
    </td>
  </tr>
  <tr>
  <td height="201" width="30%" align="center">
  </td>
    <td height="243" align="center">
    <!-- SERVICII -->
    <?php
	$sql='SELECT * FROM `pag-servicii` WHERE activ=1 ORDER BY pozitie ASC';
	$result=mysql_query($sql);
	echo '<table width="450px" height="200px" border="0" cellspacing="1" cellpadding="3" align="center">
	<th align="center" colspan="3" valign="top"><h3><u><a href="pagina.php?categorie=servicii">SERVICII</a></u></h3></th>
	';
	$num=1;
	while($row=mysql_fetch_array($result)){
		if($num==1)
			echo '<tr>';
		echo '<td align="center" valign="top"><strong>&#8226;</strong><a href="pagina.php?categorie=servicii#sectiune'.$row['pozitie'].'">'.strtoupper($row['nume']).'</a></td>';
		if($num==3){
			echo '</tr>';
			$num=0;
		}
		$num++;
	}
	echo '</table>';
	?>
    </td>
    
  </tr>
  <tr>
    <td height="201" width="30%" align="center">
    <!-- CONTACT -->
    <a href="pagina.php?categorie=contact"><img src="./images/contact.png" width="200" height="200" alt="contact" style="border:hidden;"/></a></td>
    <td width="70%" align="left" valign="bottom">
    <!-- BANNER -->
    
    
    <SCRIPT LANGUAGE="JavaScript">
<!-- Begin-->
NewImg = new Array (
<?php
$imaginedefault=NULL;
$urlddefault=NULL;
$listaimagini=NULL;
$listaurl=NULL;
$caleimagini='./pag-banner/';
$result = mysql_query("SELECT * FROM `pag-banner` WHERE activ=1 ORDER BY pozitie ASC");
while($row = mysql_fetch_array($result))
   {
	   if($imaginedefault==NULL&&$urlddefault==NULL){
		   $imaginedefault=$caleimagini.$row['nume'].'/'.$row['imagine'];
		   $urlddefault=$row['text'];
	   }
   $listaimagini=$listaimagini.'"'.$caleimagini.$row['nume'].'/'.$row['imagine'].'",';
   $listaurl=$listaurl.'"'.$row['text'].'",';
   }
 echo substr($listaimagini,0,strlen($listaimagini)-1);
 echo ');
NewHref = new Array (';
echo substr($listaurl,0,strlen($listaurl)-1);
 
?>
);
var ImgNum = 0;
var ImgLength = NewImg.length - 1;
var delay = 3500;
var runIMG;
function chgImg(direction) {
if (document.images) {
ImgNum = ImgNum + direction;
if (ImgNum > ImgLength) {
ImgNum = 0;
}
if (ImgNum < 0) {
ImgNum = ImgLength;
}
document.getElementById("bannerimage").src=NewImg[ImgNum];
document.getElementById("banner").href=NewHref[ImgNum];
   }
}
runIMG = setInterval("chgImg(1)", delay);
// <!-- End -->
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ro_RO/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script type="text/javascript">
  window.___gcfg = {lang: 'ro'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<a id="banner" href="<?php echo $urlddefault;?>" target="_new"><img src="<?php echo $imaginedefault;?>" id="bannerimage"></a>
    </td>
  </tr>
</table>

