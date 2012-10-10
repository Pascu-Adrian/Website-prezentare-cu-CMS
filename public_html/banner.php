<?php 
session_start(); 
if(!isset($_POST['upload'])) { 
echo ' 
<form name="upload" enctype="multipart/form-data" method="POST" action="'.$_SERVER['REQUEST_URI'].'"> 
<label>Selecteaza un fisier</label><input type="file" name="file" size="13" value=""> 
<br />
<label>Introdu linkul:</label><input name="url" type="text" value="http://"><br />
<input type="submit" name="upload" value="Upload"> 
</form> 
'; 
} else {  
$uploaddir = './images/banner/'; 
$filename = $_FILES['file']['name']; 
$filesize = $_FILES['file']['size']; 
$url=$_POST['url'];
$tmpname_file = $_FILES['file']['tmp_name'];  
if($filesize > '5000000') { 
echo "Way too big!!"; 
} else { 
if(!file_exists($uploaddir.$filename)){
	
if(move_uploaded_file($tmpname_file, "$uploaddir$filename")){ 
echo "Successful.<br />";

$con = mysql_connect("localhost","root","");
 if (!$con)
   {
   die('Could not connect: ' . mysql_error());
   }
 
mysql_select_db("nuntainc_artdecomariaj", $con);
 
mysql_query("INSERT INTO banner (id, imagine, url)
 VALUES ('', '$filename', '$url')");
 
mysql_close($con); 
}
else echo "eroare uploadare";
} 
else echo "fisierul exista deja, am modificat numele";
}
  } 
?> 
