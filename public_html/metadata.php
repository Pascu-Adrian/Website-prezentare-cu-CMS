<?php
require('./admin/functions.php');
session_start();
$con=mysql_connect('localhost','nuntainc_root','gigihaios');
mysql_select_db('nuntainc_artdecomariaj');
if(isset($_GET['categorie'])){
	$sql = 'SELECT * FROM `datepagini` WHERE nume=\''.$_GET['categorie'].'\'';
}
else
$sql = "SELECT * FROM `datepagini` WHERE nume='acasa'";
$result=mysql_query($sql);
if(isset($_GET['galerie'])){
	$this_galerie = $_GET['galerie'];
}
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" itemscope itemtype="http://schema.org/LocalBusiness">
<head>
<link rel="stylesheet" type="text/css" href="./main.css" />
<!-- SHARE WITH -->
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript" src="http://s.sharethis.com/loader.js"></script>

<!-- GOOGLE +1 -->
<meta itemprop="name" content="ArtDecoMariaj - Aranjamente nunti Constanta">
<meta itemprop="description" content="Organizare nunti, aranjamente nunti, fantana de ciocolata, huse de scaune, fete de masa, aranjamente nunti constanta">
<meta itemprop="image" content="http://www.nuntainconstanta.ro/images/ArtDecoMariaj_Aranjamente_Nunti_Constanta.png">


<!--META DATA-->
<META NAME="AUTHOR" CONTENT="ArtDecoMariaj WEB DESIGN"/>
<META HTTP-EQUIV="CONTENT-LANGUAGE" CONTENT="RO"/>
<META NAME="COPYRIGHT" CONTENT="&copy; ArtDecoMariaj 2011"/>
<meta name="robots" content="all,index,follow">
<META NAME="rating" CONTENT="General"/>
<META NAME="revisit-after" CONTENT="1 days"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
while($row=mysql_fetch_array($result)){
echo'
<META NAME="DESCRIPTION" CONTENT="'.$row['descriere'].'"/>
<META NAME="KEYWORDS" CONTENT="'.$row['cuvintecheie'].'"/>
<title>ArtDecoMariaj -=- '.strtoupper($row['nume']).' '.strtoupper($this_galerie).' ->Aranjamente nunti, Decoratiuni nunti, Aranjamente constanta, Aranjamente botezuri, Organizare mese festive</title>
';	
}
echo'
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
</head>';	
mysql_free_result($result);
$sql='';
?>