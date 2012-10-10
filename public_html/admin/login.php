<?php
session_start();
if(isset($_POST['username'])&&isset($_POST['password'])&&$_POST['username']!=NULL&&$_POST['password']!=NULL){
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	
	$connect = mysql_connect("localhost","nuntainc_root","gigihaios") or die ("Couldn`t connect");
	mysql_select_db("nuntainc_artdecomariaj") or die("NO DB");
	$query =  mysql_query("SELECT * FROM user WHERE username='$username'");
	$numrow= mysql_num_rows($query);
	if($numrow!=0)
{
	while($row=mysql_fetch_assoc($query)){
		$dbusername = $row['username'];
		$dbpassword = $row['password'];	
	}
	if($username==$dbusername&&$password==$dbpassword){
		$_SESSION['username']=$dbusername;
		echo 'LOGARE REUSITA! CLICK <a href="./index.php"/>AICI</a> PENTRU A CONTINUA';	
		
		}
		else{
			echo 'PAROLA INCORECTA! <br/><a href="./index.php">INAPOI</a>';
		}
}
else 
die('USERUL INTRODUS NU EXISTA! <br/><a href="./index.php">INAPOI</a>');
}

else
die('ESTE NECESAR SA COMPLETATI TOATE CAMPURILE PENTRU A VA LOGA! <br/><a href="./index.php">INAPOI</a>');

mysql_close($connect);
?>