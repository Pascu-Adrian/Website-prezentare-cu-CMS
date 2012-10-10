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
    <td width="25%" align="left" valign="top" id="sitemapplace">
    <!-- SITEMAP -->
  <?php include('./sitemap.php');?>
  	<!-- END SITEMAP -->
    </td>
    <td width="75%"  align="center">
    <!-- BODY -->


<?php
header('Location: pagina.php?categorie=acasa');
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
    </td>
  </tr>
</table>


<!-- FLOATMENU-->
<?php include('./floatmenu.php')?>
<!-- END FLOATMENU-->
</body>
</html>

<!-- functions -->

<?php



?>