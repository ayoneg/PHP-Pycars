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

        echo '<div class="panel_div info_">';
        echo '<div class="panel_head info">';
	    echo '<i class="fa fa-spinner fa-spin"></i> Oczekujące na akceptacje ...';
		$spr1i = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_post WHERE post_value='0'"));
	    echo '</div>';
        echo '<div class="panel_body">';
        echo 'Trwa oczekiwanie na sprawdzenie przez moderatora...</br>';
		echo 'Oczekujących: '.$spr1i['COUNT(*)'].'</br>';
        echo '</div>';
        echo '</div>';

$wynik = mysql_query("SELECT * FROM global_post WHERE post_value='0' ORDER BY post_id DESC") or die('Błąd zapytania'); 
if(mysql_num_rows($wynik) > 0) { 
    while($r = mysql_fetch_assoc($wynik)) { 
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$r['post_user']."'"));
     echo '<div class="post_content_1">';
	
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$r['post_id']."'"));
     echo '<div class="image_post" style="float: left;"><a href="/post/?q='.$r['post_id'].'"><img src="'.$spr1c['file_url'].'" title="'.$r['post_title'].'" width="100px" height="100px"></img></a></div>';
	 $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
     $r['post_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $r['post_desc']);
	 echo '<div class="desc_post" style="margin-left: 100px;">'.$r['post_desc'].'</div>';
     echo '<div class="info_post" style="float: left;">Dodano: '.$r['post_data'].' przez: '.$spr1b['user_nick'].'</div>';
	 echo '<div style="clear: both;"></div>';

     echo '</div>';
	 
	}
} else {
	
     //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$r['post_user']."'"));
     echo '<div class="post_content_1">';
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$r['post_id']."'"));
     echo '<div class="image_post"><a href="/post/?q='.$r['post_id'].'"></a></div>';
     echo '</div>';
}

?>



</div>
</div>

<?php include('../in/footer.php'); ?>


</body>
</html>

