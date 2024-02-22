<?php include('../dbcon.php'); session_start(); ?>
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

if($_SESSION['user_id']){
$spr1h = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$_SESSION['user_id']."'"));	
if($spr1h['user_perm']==100 OR $spr1h['user_perm']==90){
	
echo '<h1>GLOBALNE POWIADOMIENIA</h1>';		
	
echo '<form style="text-align: center;" method="post" action="?send=start">'; 
  echo '<select class="sellect" name="pow_type">';
  echo '<option value="1">INFO</option>';
  echo '<option value="2">WARNING</option>';
  echo '<option value="3">ERROR</option>';
  echo '<option value="4">OKEY</option>';
  echo '</select>';
	echo '<input type="text" name="pow_icon" placeholder="fa fa icon">';
	echo '<textarea style="width: 600px;padding: 5px;" name="pow_text" placeholder="Treść powiadomienia"></textarea><br>';
    echo '<input type="submit" class="filebuton" value="Wyślij powiadomienie">';
echo '</form>';	
if($_GET['send']=='start'){
$pow_type=$_POST['pow_type'];
$pow_data=date('Y-m-d H:i:s');	
$wynik = mysql_query("SELECT * FROM global_users") or die('Błąd zapytania'); 
while($r = mysql_fetch_assoc($wynik)) { 
mysql_query("INSERT INTO global_pow SET pow_user_id='".$r['user_id']."', pow_text='".$_POST['pow_text']."', pow_icon='".$_POST['pow_icon']."', pow_value='0', pow_type='".$_POST['pow_type']."', pow_data='$pow_data', pow_ck='0'")or die('Brak połączenia z serwerem MySQL. <br />Błąd: '.mysql_error());
}
}
	
	
echo '<h1>AKCEPTACJE POSTÓW</h1>';	

$wynik = mysql_query("SELECT * FROM global_post WHERE post_value=0 ORDER BY post_id DESC") or die('Błąd zapytania'); 
if(mysql_num_rows($wynik) > 0) { 
    while($r = mysql_fetch_assoc($wynik)) { 
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$r['post_user']."'"));
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$r['post_id']."'"));
     echo '<a target="_blank" href="'.$spr1c['file_url'].'">Obrazek</a> | <a title="'.$r['post_desc'].'">Opis</a> | Dodano: '.$r['post_data'].' przez: '.$spr1b['user_nick'].' | <a href="?q='.$r['post_id'].'&a=a&user='.$r['post_user'].'"><b style="color: green;">AKCEPTUJ</b></a> | <a href="?q='.$r['post_id'].'&a=u&user='.$r['post_user'].'"><b style="color: red;">USUŃ</b></a> |</br>';
	 
	}
}else{
echo '<p>Brak postów...</p>';	
}

   //DODAJ
   if($_GET['a']=='a'){
   mysql_query("UPDATE global_post SET post_value=1 WHERE post_id='".$_GET['q']."'");  
   
		$pow_text = 'Twój post został przyjęty przez moderatora! Post otrzymuje pełnie opcji.';
		$pow_icon = 'fa fa-bell';
		$pow_data = date('Y-m-d H:i:s');
		mysql_query("INSERT INTO global_pow SET pow_user_id='".$_GET['user']."', pow_text='$pow_text', pow_icon='$pow_icon', pow_value='0', pow_type='4', pow_data='$pow_data', pow_ck='0'")or die('Brak połączenia z serwerem MySQL. <br />Błąd: '.mysql_error());    
header("Location: /mod-room/");	
   }
   //USUŃ
   if($_GET['a']=='u'){
   mysql_query("DELETE FROM global_post WHERE post_id='".$_GET['q']."'"); 
   $pre = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id='".$_GET['q']."'")); 
   mysql_query("DELETE FROM global_users_files WHERE file_post_id='".$_GET['q']."'"); 
   
		$pow_text = 'Twój posty został zablokowany przez moderatora ze względów łamania regulaminu. Otrzymujesz tymczasową blokadę ograniczającą twoje konto.';
		$pow_icon = 'fa fa-bell';
		$pow_data = date('Y-m-d H:i:s');
		mysql_query("INSERT INTO global_pow SET pow_user_id='".$_GET['user']."', pow_text='$pow_text', pow_icon='$pow_icon', pow_value='0', pow_type='3', pow_data='$pow_data', pow_ck='0'");  
$start = date('Y-m-d H:i:s');
$ts = strtotime($start);
if (date('Y-m-d H:i:s', $ts) != $start)
throw new Exception('Błąd konwersji');
$ban_data = date('Y-m-d H:i:s', strtotime('+3 days', $ts));		
mysql_query("INSERT INTO global_bans SET ban_user='".$_GET['user']."', ban_value='1', ban_data_do='$ban_data'"); 
header("Location: /mod-room/");	
   }


echo '<h1>NIEAKTUALNE / SPRZEDANE</h1>';	

$wynik = mysql_query("SELECT * FROM global_post WHERE post_value=5 ORDER BY post_id DESC") or die('Błąd zapytania'); 
if(mysql_num_rows($wynik) > 0) { 
    while($r = mysql_fetch_assoc($wynik)) { 
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$r['post_user']."'"));
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$r['post_id']."'"));
     echo '<a target="_blank" href="'.$spr1c['file_url'].'">Obrazek</a> | <a title="'.$r['post_desc'].'">Opis</a> | Dodano: '.$r['post_data'].' przez: '.$spr1b['user_nick'].' | <a href="?q='.$r['post_id'].'&p=a&user='.$r['post_user'].'"><b style="color: green;">AKCEPTUJ</b></a> |</br>';
	 
	}
}else{
echo '<p>Brak postów...</p>';	
}   
if($_GET['p']=='a'){
   mysql_query("UPDATE global_post SET post_value=6 WHERE post_id='".$_GET['q']."'");  
   
		$pow_text = 'Twój post został pomyślnie wyłączony przez moderatora.';
		$pow_icon = 'fa fa-bell';
		$pow_data = date('Y-m-d H:i:s');
		mysql_query("INSERT INTO global_pow SET pow_user_id='".$_GET['user']."', pow_text='$pow_text', pow_icon='$pow_icon', pow_value='0', pow_type='4', pow_data='$pow_data', pow_ck='0'")or die('Brak połączenia z serwerem MySQL. <br />Błąd: '.mysql_error());    
header("Location: /mod-room/");		
}   
   

}else{
echo '<div class="panel_div error_">';
    echo '<div class="panel_head error">';
	    echo 'Brak uprawnień!';
	echo '</div>';
    echo '<div class="panel_body">';
        echo 'Niestety nie posiadasz uprawnień, aby zobaczyć tę stronę!';
    echo '</div>';
echo '</div>';
}
}else{
echo '<div class="panel_div warning_">';
    echo '<div class="panel_head warning">';
	    echo 'Uwaga!';
	echo '</div>';
    echo '<div class="panel_body">';
        echo 'Wymagana autoryzacja na stronie! Zaloguj się by kontynuować!';
    echo '</div>';
echo '</div>';
}
?>



</div>
</div>

<?php include('../in/footer.php'); ?>


</body>
</html>
















