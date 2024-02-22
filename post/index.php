<?php 
include('../dbcon.php'); session_start(); 
$spr1f = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id=".$_GET['q']." ORDER BY post_id DESC"));
$spr1g = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$spr1f['post_user']."'"));
?>
<!doctype html>
<html lang="pl">
<head>
<!-- Strefa HEAD -->

<!-- Opis, tytuł, autor, kodowanie -->
<title>Giełda online! - Kupuj, sprzedawaj i licytuj!</title>
<meta charset="utf-8">
<meta name="description" content="Giełda online, kupuj, sprzedawaj i licytuj!">
<meta name="author" content="Iron_NOW, Ajon">
<link rel="shortcut icon" href="https://i.imgur.com/y5zfdEs.png">

<!-- style, skrypty -->
<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
<link rel="stylesheet" href="/style/page.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Konec strefy HEAD -->
</head>
<body id="global">
<?php include('../in/top_menu.php'); ?>


<div id="center_body">
<div id="in_center_body">

<?php

$wynik = mysql_query("SELECT * FROM global_post WHERE post_id=".$_GET['q']." ORDER BY post_id DESC") or die('Błąd zapytania'); 
if(mysql_num_rows($wynik) > 0) { 
    while($r = mysql_fetch_assoc($wynik)) { 
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$r['post_user']."'"));
     echo '<div class="post_content_1">';
	 $wynik2 = mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$_GET['q']."'") or die('Błąd zapytania'); 
     while($spr1c = mysql_fetch_assoc($wynik2)) { 	
	 if($r['post_value']==5){echo '<div style="position: absolute;"><img src="/images/sold.png"></div>';}
	 if($r['post_value']==6){echo '<div style="position: absolute;"><img src="/images/sold.png"></div>';}
     echo '<div class="image_post"><img src="'.$spr1c['file_url'].'" title="'.$r['post_title'].'" width="100%"></img></div>';
	 }
	 $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
     $r['post_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $r['post_desc']);
	 echo '<div class="desc_post">'.$r['post_desc'].'</div>';
	 $czom_q = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_com WHERE com_value>'0' AND com_post_id='".$r['post_id']."'"));
	 $count_views = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id='".$r['post_id']."'"));
	 $count_reports = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_reports WHERE report_post_id='".$r['post_id']."'"));
	 $cost = number_format($r['post_car_cost'], 2, ',', ' ');
	 $kp = number_format($r['post_car_kp']);	 
	 $_car_i = mysql_fetch_array(mysql_query("SELECT * FROM cars_info WHERE car_id='".$r['post_car_name']."'"));
	 echo '<div class="list_img"><a href="/post/?q='.$r['post_id'].'"><img src="'.$_car_i['car_img'].'" height="150px" width="150px"></a></div>';
	 echo '<div class="list_desc">
	 <div class="title_car">'.$_car_i['car_name'].'</div>
	 <div> 
<table style="width:100%;font-size: 20px;">
<tr>
<td><b>Cena:</b></td>
<td>'.$cost.'€ (w tym '.$_car_i['car_pod'].'€ pod.)</td> 
</tr>
<tr>
<td><b>Przebieg:</b></td>
<td>'.$kp.'km</td> 
</tr>
<tr>
<td><b>ID pojazdu:</b></td>
<td>'.$r['post_car_id'].'</td> 
</tr>
<tr>
<td><b>Tuning:</b></td>
<td>'.$r['post_car_tune'].'</td> 
</tr>
<td><b>Tuning wizualny:</b></td>
<td>'.$r['post_car_visu'].'</td> 
</tr>
</table>
	 
	 </div>
	 </div>';
     echo '<div style="clear: both;"></div>';
if($r['post_user']==$_SESSION['user_id']){
if($r['post_value']==6){}else{
	if($r['post_value']==5){
	echo '<div>Ten post jest już niewidoczny, oczekuje na moderatora... <a href="/post/?q='.$_GET['q'].'&post=1">[Anuluj]</a></div>';
    if($_GET['post']==1){
		mysql_query("UPDATE global_post SET post_value=1 WHERE post_id='".$_GET['q']."'");
		Header("Location: /post/?q=".$_GET['q']."");	
	}	
	}else{
		echo'<div><a href="/post/?q='.$_GET['q'].'&post=5">Zgłoś (usunięcie ogłoszenia / nieaktualność) </a></div>';
		if($_GET['post']==5){	
			mysql_query("UPDATE global_post SET post_value=5 WHERE post_id='".$_GET['q']."'");
			Header("Location: /post/?q=".$_GET['q']."");
		}
	}
}
}else{
     echo '<div class="_button_2">';	//kup teraz
     	 echo 'Kup Teraz!';
	 echo '</div>';	
} 
     echo '<div class="info_post">Dodano: '.$r['post_data'].' przez: <a href="/profil/?user='.$r['post_user'].'">'.$spr1b['user_nick'].'</a> | Views: '.$count_views['COUNT(*)'].' | <a title="Reports ['.$count_reports['COUNT(*)'].'/5]" href="/reports/?_type=1&_post='.$r['post_id'].'" style="color: red;">Report</a></div>';

	// komentarze
	 
	if($_SESSION['user_id']){
    $ban = mysql_fetch_array(mysql_query("SELECT * FROM global_bans WHERE ban_user='".$_SESSION['user_id']."'"));
    if($ban['ban_value']<>2){
	if($r['post_value']==0){}else{	
	echo '<form style="text-align: center;padding: 5px;" method="post" action="?c=a&q='.$_GET['q'].'">'; 
	echo '<textarea maxlength="150" style="width: 600px;padding: 5px;" name="com_desc" placeholder="Tereść komentarza (max 150 znaków)"></textarea>';
    echo '<input type="submit" style="width: 100px;float: left;margin-top: 25px;" class="filebuton" value="Dodaj">';
    echo '</form>';	
	if($_GET['c']=='a'){
	$com_desc=$_POST['com_desc'];
	$com_data=date('Y-m-d H:i:s');
	if(strlen($com_desc)>2){
	mysql_query("INSERT INTO global_com SET com_user_id='".$_SESSION['user_id']."', com_data='$com_data', com_desc='$com_desc', com_value='1', com_post_id='".$_GET['q']."'");
	header("refresh:0;url=/post/?q=".$_GET['q']);
	}
	}
	}
	}else{
echo '<div class="panel_div error_">';
    echo '<div class="panel_head error">';
	    echo 'Brak uprawnień!';
	echo '</div>';
    echo '<div class="panel_body">';
        echo 'Niestety nie posiadasz uprawnień, aby dodać nowy komentarz!';
    echo '</div>';
echo '</div>';	
	}
	}

    //views
	$views_data=date('Y-m-d H:i:s');
	$views_ip=$_SERVER['REMOTE_ADDR'];
	$views_spr_1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id='".$r['post_id']."' AND views_ip='".$views_ip."'"));
	if($views_spr_1['COUNT(*)']>=3){}else{
	mysql_query("INSERT INTO global_views SET views_data='$views_data', views_ip='$views_ip', views_post_id='".$_GET['q']."'");
	}
	//end
	
	echo '<div class="com_post">';
	$wynik2 = mysql_query("SELECT * FROM global_com WHERE com_value>'0' AND com_post_id='".$_GET['q']."' ORDER BY com_id DESC") or die('Błąd zapytania'); 
    if(mysql_num_rows($wynik2) > 0) { 
    while($r2 = mysql_fetch_assoc($wynik2)) { 
	$spr1i = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$r2['com_user_id']."'"));
    $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
    $r2['com_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $r2['com_desc']);	
	echo '<div class="list_com"><a href="/profil/?user='.$spr1i['user_id'].'">'.$spr1i['user_nick'].'</a>: '.$r2['com_desc'].'</div>';
	}
	}else{
    if($r['post_value']==0){
	echo '<div class="list_com"><a>BOTradek</a>: Ten post oczekuje na akceptacje, tymczasowa blokada komentowania.</div>';		
	}else{	
		
	}
	}
	 echo '</div>';
     echo '</div>';
	 
	}
}

?>



</div>
</div>

<?php include('../in/footer.php'); ?>


</body>
</html>
















