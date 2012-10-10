        <?php
//session_start();
$con=mysql_connect('localhost','nuntainc_root','gigihaios');
mysql_select_db('nuntainc_artdecomariaj');

if(isset($_POST['schimba']))
    {
	if(isset($_GET['numetabel']))
            {
		$numetabel=$_GET['numetabel'];

            if(isset($_GET['coloana']))
                {
                    $coloana=$_GET['coloana'];

                if(isset($_GET['id']))
                    {

                    $id=$_GET['id'];
                    $sql='SELECT * FROM `'.$numetabel.'` WHERE id='.$id;
                    $result = mysql_query($sql) or die("mysql error:".mysql_error());
                    if(mysql_num_rows($result)>0)
                        {

                        echo'
                        Esti sigur ca doresti sa schimbi atributul: '.strtoupper($coloana).'<br/>
                        al obiectului de tip: '.strtoupper(substr($numetabel, 4, strlen($numetabel))).'<br/>
                        cu ID-ul:'.$id.'<br/>
                        ';
                        while($get=mysql_fetch_array($result))
                            {
                            if($coloana=='nume')
                                {
                                echo 'Valoarea actuala a atributului este: '.$get[$coloana].'<br/>
                                <form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'?numetabel='.$numetabel.'&coloana='.$coloana.'&id='.$id;
								if(isset($_GET['fkey']))
									echo '&fkey='.$_GET['fkey'];
								echo'" method="post"><label>'.strtoupper($coloana).'</label><input name="data" type="text"><input name="ok" type="submit" value="SCHIMBA"></form>
                                <form enctype="multipart/form-data" action="'.$_SERVER['HTTP_REFERER'].'" method="post"><input name="anuleaza" type="submit" value="ANULEAZA"></form>
                                ';
                                }
                            if($coloana=='text')
                                {
                                echo 'Valoarea actuala a atributului este: '.$get[$coloana].'<br/>
                                <form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'?numetabel='.$numetabel.'&coloana='.$coloana.'&id='.$id;
								if(isset($_GET['fkey']))
									echo '&fkey='.$_GET['fkey'];
								echo'" method="post"><label>'.strtoupper($coloana).'</label><textarea name="data" cols="100" rows="20">'.$get['text'].'</textarea><input name="ok" type="submit" value="SCHIMBA"></form>
                                <form enctype="multipart/form-data" action="'.$_SERVER['HTTP_REFERER'].'" method="post"><input name="anuleaza" type="submit" value="ANULEAZA"></form>
                                ';
                                }
                            if($coloana=='imagine')
                                {
                                echo 'Valoarea actuala a atributului este: <img src="../'.$numetabel.'/'.$get['nume'].'/'.$get[$coloana].'" width="200px" height="200px"><br/>
                                <form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'?numetabel='.$numetabel.'&coloana='.$coloana.'&id='.$id; 
								if(isset($_GET['fkey']))
									echo '&fkey='.$_GET['fkey'];
								echo '" method="post"><label>'.strtoupper($coloana).'</label><input name="data" type="file" size="100"><input name="ok" type="submit" value="SCHIMBA CU IMAGINEA INTRODUSA"></form>
                                <form enctype="multipart/form-data" action="'.$_SERVER['HTTP_REFERER'].'" method="post"><input name="anuleaza" type="submit" value="ANULEAZA"></form><br/>
                                SAU SELECTATI O IMAGINE DIN LISTA DE MAI JOS:<br/>
                                <form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'?numetabel='.$numetabel.'&coloana='.$coloana.'&id='.$id;
								if(isset($_GET['fkey']))
									echo '&fkey='.$_GET['fkey'];
								echo'" method="post"><input name="ok" type="submit" value="SCHIMBA CU IMAGINEA SELECTATA">';
                                echo '<table border="0" align="center" cellspacing="20" cellspacing="10">';
                                afiseazaimaginidirector('../'.$numetabel.'/'.$get['nume'],'',$get[$coloana]);
                                echo '</table>';
                                echo '
                                </form>
                                ';
                                }
                            if($coloana=='pozitieimagine')
                                {
                                $rezultat=mysql_query("SELECT * FROM pozitieimagine");
                                echo 'Valoarea actuala a atributului este: '.$get[$coloana].'<br/>
                                <form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'?numetabel='.$numetabel.'&coloana='.$coloana.'&id='.$id;
								if(isset($_GET['fkey']))
									echo '&fkey='.$_GET['fkey'];
								echo '" method="post"><label>'.strtoupper($coloana).'</label>
                                <select name="data">';
                                while($getrow=mysql_fetch_array($rezultat))
                                    {
                                    echo '
                                    <option value="'.$getrow['id'].'" selected>'.$getrow['nume'].'</option>
                                    ';
                                    }
                                echo '</select><input name="ok" type="submit" value="SCHIMBA"></form>
                                <form enctype="multipart/form-data" action="'.$_SERVER['HTTP_REFERER'].'" method="post"><input name="anuleaza" type="submit" value="ANULEAZA"></form>
                                ';
                                }
                                if($coloana=='pozitie')
                                    {
										if(isset($_GET['fkey']))
										$sql='SELECT * FROM `'.$numetabel.'` WHERE idcategorie='.$_GET['fkey'].' ORDER BY pozitie ASC';
										else
											$sql='SELECT * FROM `'.$numetabel.'` ORDER BY pozitie ASC';
										$rezultat=mysql_query($sql);
									echo 'Valoarea actuala a atributului este: '.$get[$coloana].'<br/>
                                    <form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'?numetabel='.$numetabel.'&coloana='.$coloana.'&id='.$id;
									if(isset($_GET['fkey']))
									echo '&fkey='.$_GET['fkey'];
									echo '" method="post"><label>'.strtoupper($coloana).'</label>
                                    <select name="data">';
									while($get=mysql_fetch_array($rezultat)){
										echo '
										<option value="'.$get['pozitie'].'" '; 
										if($get['id']==$id)echo 'selected';
										
										echo '>'.$get['pozitie'].'</option>
										';
									}
                                    
                                    echo '</select><input name="ok" type="submit" value="SCHIMBA"></form>
                                    <form enctype="multipart/form-data" action="'.$_SERVER['HTTP_REFERER'].'" method="post"><input name="anuleaza" type="submit" value="ANULEAZA"></form>
                                    ';
                                }
                                if($coloana=='activ')
                                    {
                                    echo 'Valoarea actuala a atributului este: '.$get[$coloana].'<br/>
                                    <form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'?numetabel='.$numetabel.'&coloana='.$coloana.'&id='.$id;
									if(isset($_GET['fkey']))
									echo '&fkey='.$_GET['fkey'];
									echo '" method="post"><label>'.strtoupper($coloana).'</label>
                                    <select name="data">
                                    <option value="0" selected>INACTIV</option>
                                    <option value="1">ACTIV</option>
                                    </select><input name="ok" type="submit" value="SCHIMBA"></form>
                                    <form enctype="multipart/form-data" action="'.$_SERVER['HTTP_REFERER'].'" method="post"><input name="anuleaza" type="submit" value="ANULEAZA"></form>
                                    ';
                                    }
                                if($coloana=='pret')
                                    {
                                    echo 'Valoarea actuala a atributului este: '.$get[$coloana].'<br/>
                                    <form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'?numetabel='.$numetabel.'&coloana='.$coloana.'&id='.$id;
									if(isset($_GET['fkey']))
									echo '&fkey='.$_GET['fkey'];
									echo '" method="post"><label>'.strtoupper($coloana).'</label><input name="data" type="text"><input name="ok" type="submit" value="SCHIMBA"></form>
                                    <form enctype="multipart/form-data" action="'.$_SERVER['HTTP_REFERER'].'" method="post"><input name="anuleaza" type="submit" value="ANULEAZA"></form>
                                    ';
                                }
                            }
                        }
                        mysql_free_result($result);
                    }
                    else
                        header('Location: index.php');
                }
                else
                    header('Location: index.php');
            }
            else
                header('Location: index.php');
        }
        elseif(isset($_POST['ok']))
            {
            if(isset($_GET['numetabel']))
                {
		$numetabel=$_GET['numetabel'];

			$categorie='pagini';

                if(isset($_GET['coloana']))
                    {
                    $coloana=$_GET['coloana'];
                    if(isset($_GET['id']))
                    {
                    $id=$_GET['id'];
                    if(isset($_POST['data'])&&$_POST['data']!=NULL||isset($_FILES['data']))
                        {
			if(isset($_POST['data']))
                            {
                            $data=$_POST['data'];
                            }
			if($coloana=='imagine')
                            {
                            if(isset($_FILES['data']))
                                {
								$data = $_FILES['data']['name'];
								$filename=$_FILES['data']['name'];
                                }
                            elseif(isset($_POST['data']))
                                {
                                $filename=$_POST['data'];
                                }
                            $parts = explode('.',$filename);
                            $extensie[]= end($parts);
                            if($extensie[0]=='png'||$extensie[0]=='jpg'||$extensie[0]=='jpeg'||$extensie[0]=='bmp'||$extensie[0]=='gif')
				{
				if(!file_exists('../'.$numetabel))
                                    {
                                    mkdir('../'.$numetabel,0777);
                                    }
                                $query='SELECT * FROM `'.$numetabel.'` WHERE id='.$id;
				$rez=mysql_query($query);
                                while($getrowval=mysql_fetch_array($rez))
                                    {
                                    if(!file_exists('../'.$numetabel.'/'.$getrowval['nume']))
					{
					mkdir('../'.$numetabel.'/'.$getrowval['nume'],0777);
					}
                                    if(isset($_FILES['data']))
                                        {
                                        $filename=$_FILES['data']['name'];
                                        if(file_exists('../'.$numetabel.'/'.$getrowval['nume'].'/'.$filename))
                                            {
                                            for($number=0;$number<6000;$number++)
                                                {
                                                $filename=$number.$fisier;
						if(file_exists('../'.$numetabel.'/'.$getrowval['nume'].'/'.$filename))
                                                    continue;
						else
                                                    break;
						}
                                            }
                                         else
                                            {
                                            if(move_uploaded_file($_FILES['data']['tmp_name'], '../'.$numetabel.'/'.$getrowval['nume'].'/'.$filename))
                                                {
						$filename=$filename;
						}
                                            else die('NU S-A PUTUT UPLOADA FISIERUL');
                                            }

                                         }
                                         elseif(isset($_POST['data']))
                                             {
                                              $filename=$_POST['data'];
                                             }
                                         $sqlmodif='UPDATE `'.$numetabel.'` SET `'.$coloana.'`=\''.$filename.'\' WHERE `id`='.$id;
                                         mysql_query($sqlmodif) or die("mysql error:".mysql_error());
										 $data='<img src="../'.$numetabel.'/'.$getrowval['nume'].'/'.$filename.'" height="200px" width="200px">';
					}
                                    }
                                    if($extensie[0]!='png'&&$extensie[0]!='jpg'&&$extensie[0]!='jpeg'&&$extensie[0]!='bmp'&&$extensie[0]!='gif')
                                        {
					echo 'FISIERUL INTRODUS NU ESTE DE TIP IMAGINE!<br/>
					<form enctype="multipart/form-data" action="schimba.php?numetabel='.$numetabel.'&coloana='.$coloana.'&id='.$id;
					if(isset($_GET['fkey']))
									echo '&fkey='.$_GET['fkey'];
					echo '" method="post"><input name="schimba" type="submit" value="OK"></form>';
                                        }

                            }
                            elseif($coloana=='pozitie'){
								$newsqlquery='SELECT * FROM `'.$numetabel.'` WHERE id='.$id;
								$newresult=mysql_query($newsqlquery);
								while($atribut=mysql_fetch_array($newresult)){
									schimbapozitie($numetabel,$atribut['pozitie'],$data);
								}
								
									
                            }
							elseif($coloana=='nume'){
								 $query='SELECT * FROM `'.$numetabel.'` WHERE id='.$id;
				$rez=mysql_query($query);
                                while($getrowval=mysql_fetch_array($rez))
                                    {
									if(file_exists('../'.$numetabel.'/'.$getrowval['nume']))
										{
											rename('../'.$numetabel.'/'.$getrowval['nume'],'../'.$numetabel.'/'.$data);
										}
									}
								$sqlmodif='UPDATE `'.$numetabel.'` SET `'.$coloana.'`=\''.$data.'\' WHERE `id`='.$id;
                                mysql_query($sqlmodif) or die("mysql error:".mysql_error());	
                            }
                            else
                                {
				$sqlmodif='UPDATE `'.$numetabel.'` SET `'.$coloana.'`=\''.$data.'\' WHERE `id`='.$id;
                                mysql_query($sqlmodif) or die("mysql error:".mysql_error());
                                }
                                echo '
                                Am modificat atributul: '.$coloana.' pentru obiectul de tip: '.strtoupper(substr($numetabel, 4, strlen($numetabel))).' cu idul: '.$id.'<br/>
                                Noua valoare a atributului este: '.$data.'
                                <form enctype="multipart/form-data" action="index.php?categorie='.$categorie.'&numetabel='.$numetabel;
								if(isset($_GET['fkey']))
									echo '&fkey='.$_GET['fkey'];
								echo '" method="post"><input name="ok" type="submit" value="OK"></form>';

                           }
                           else{ echo '
                            INTRODUCETI O VALOARE VALIDA IN CAMPUL OFERIT!<br/>
                            <form enctype="multipart/form-data" action="schimba.php?numetabel='.$numetabel.'&coloana='.$coloana.'&id='.$id;
							if(isset($_GET['fkey']))
									echo '&fkey='.$_GET['fkey'];
							echo'" method="post"><input name="schimba" type="submit" value="OK"></form>';}
                        }
                        else
                            header('Location: index.php');
                    }
                    else
                        header('Location: index.php');
                }
                else
                    header('Location: index.php');
            }
            else
                header('Location: index.php');

function incepecu($string,$prefix){
	for($i=0;$i<strlen($prefix);$i++){
		if($string[$i]==$prefix[$i]){
			continue;
		}
		else return false;
	}
	return true;
}

 function afiseazaimaginidirector($director,$limit,$valoareactuala){
$dir_handle = @opendir($director) or die("Unable to open $director");
if($limit!=NULL)
$limita=$limit;
else
$limita=1;
     while (false !== ($file = readdir($dir_handle)))
    {

		$parts=NULL;
		$extensie[]=NULL;
         if($file!="." && $file!="..")
         {
             if (is_dir($director."/".$file))
             {
                 //Display a list of sub folders.
                 afiseazaimaginidirector($director."/".$file,$limita,$valoareactuala);
             }
             else
             {
				 $parts = explode('.',$file);
					$extensie[0]= end($parts);
				if($limita==1) echo '<tr>';
                if($extensie[0]=='png'||$extensie[0]=='jpg'||$extensie[0]=='jpeg'||$extensie[0]=='bmp'||$extensie[0]=='gif'){
					echo '<td>';
					echo '<img src="'.$director.'/'.$file.'" height="170" width="170"><br/>';
					echo '<label>SELECTEAZA: </label><input name="data" type="radio" value="'.$file.'" ';if($file==$valoareactuala)echo 'checked';echo '>';
					echo '</td>';
				}
				if($limita==5){
				$limita=0;
				echo '</tr>';
				}
				$limita++;
             }
         }
     }
    //closing the directory
     closedir($dir_handle);
 }
 function schimbapozitie($tabel,$valoaredeschimbat,$valoarenoua){
	 $sqlquery="SELECT * FROM `".$tabel.'`';
	 if(isset($_GET['fkey']))
	 	$sqlquery=$sqlquery.' WHERE idcategorie='.$_GET['fkey'];
	 $sqlquery=$sqlquery.' ORDER BY pozitie ASC';
	 $rezultatsqlquery=mysql_query($sqlquery);
	 $gasit=false;
	 if($valoaredeschimbat>$valoarenoua){
			while($get=mysql_fetch_array($rezultatsqlquery)){
					if(!$gasit){
						if($get['pozitie']!=$valoarenoua){
							continue;
						}
											elseif($get['pozitie']==$valoarenoua){
												//increment
												$valoaretemp=$get['pozitie']+1;											
									$sqlmodif='UPDATE `'.$tabel.'` SET pozitie=\''.$valoaretemp.'\' WHERE `id`='.$get['id'];
                                				mysql_query($sqlmodif) or die("mysql error:".mysql_error());
												$gasit=true;
											}
										}
										elseif($gasit){
											if($get['pozitie']!=$valoaredeschimbat){
												//increment
												$valoaretemp=$get['pozitie']+1;											
									$sqlmodif='UPDATE `'.$tabel.'` SET pozitie=\''.$valoaretemp.'\' WHERE `id`='.$get['id'];
                                				mysql_query($sqlmodif) or die("mysql error:".mysql_error());
											}
											elseif($get['pozitie']==$valoaredeschimbat){
												//schimba
										$sqlmodif='UPDATE `'.$tabel.'` SET pozitie=\''.$valoarenoua.'\' WHERE `id`='.$get['id'];
                                				mysql_query($sqlmodif) or die("mysql error:".mysql_error());
												break;
											}
										}
									}
								}
								if($valoaredeschimbat<$valoarenoua){
									while($get=mysql_fetch_array($rezultatsqlquery)){
										if(!$gasit){
											if($get['pozitie']!=$valoaredeschimbat){
												continue;
											}
											elseif($get['pozitie']==$valoaredeschimbat){
									$sqlmodif='UPDATE `'.$tabel.'` SET pozitie=\''.$valoarenoua.'\' WHERE `id`='.$get['id'];
                                				mysql_query($sqlmodif) or die("mysql error:".mysql_error());
												$gasit=true;
											}
										}
										elseif($gasit){
											if($get['pozitie']!=$valoarenoua){
												//decrement
												$valoaretemp=$get['pozitie']-1;											
									$sqlmodif='UPDATE `'.$tabel.'` SET pozitie=\''.$valoaretemp.'\' WHERE `id`='.$get['id'];
                                				mysql_query($sqlmodif) or die("mysql error:".mysql_error());
											}
											elseif($get['pozitie']==$valoarenoua){
												//decrement
												$valoaretemp=$get['pozitie']-1;											
									$sqlmodif='UPDATE `'.$tabel.'` SET pozitie=\''.$valoaretemp.'\' WHERE `id`='.$get['id'];
                                				mysql_query($sqlmodif) or die("mysql error:".mysql_error());
												break;
											}
										}
									}
								}
 }
        ?>