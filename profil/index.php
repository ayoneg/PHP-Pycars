<?php include('../dbcon.php'); session_start(); $post_user=$_GET['user']; $spr1d = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$post_user."'"));?>
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
if($_SESSION['user_id']==$post_user){
echo '<div class="panel_div info_">';
    echo '<div class="panel_head info">';
	    echo 'Informacja';
	echo '</div>';
    echo '<div class="panel_body">';
        echo 'Tutaj wyświetlane będą wszystkie twoje dodane oferty.';
    echo '</div>';
echo '</div>';
}
	if($_GET['page']>0){
	$od_p=$_GET['page']*5;	
	$wynik = mysql_query("SELECT * FROM global_post WHERE post_value>'0' AND post_user='".$post_user."' ORDER BY post_id DESC LIMIT ".$od_p.",5") or die('Błąd zapytania'); 	
	}else{
	$wynik = mysql_query("SELECT * FROM global_post WHERE post_value>'0' AND post_user='".$post_user."' ORDER BY post_id DESC LIMIT 0,5") or die('Błąd zapytania'); 	
	}
if(mysql_num_rows($wynik) > 0) { 
    while($r = mysql_fetch_assoc($wynik)) { 
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$r['post_user']."'"));
     echo '<div class="post_content_1">';
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$r['post_id']."'"));
	 if($r['post_value']==5){echo '<div style="position: absolute;"><img src="/images/sold.png"></div>';}
	 if($r['post_value']==6){echo '<div style="position: absolute;"><img src="/images/sold.png"></div>';}
     echo '<div class="image_post"><a href="/post/?q='.$r['post_id'].'"><img src="'.$spr1c['file_url'].'" title="'.$r['post_title'].'" width="100%"></img></a></div>';
	 $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
     $r['post_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $r['post_desc']);
	 echo '<div class="desc_post">'.$r['post_desc'].'</div>';
     $czom_q = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_com WHERE com_value>'0' AND com_post_id='".$r['post_id']."'"));
	 $count_views = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id='".$r['post_id']."'"));
	 $count_reports = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_reports WHERE report_post_id='".$r['post_id']."'"));
     echo '<div class="info_post">Dodano: '.$r['post_data'].' przez: <a href="/profil/?user='.$r['post_user'].'">'.$spr1b['user_nick'].'</a> | <a href="/post/?q='.$r['post_id'].'">Komentarze</a> ['.$czom_q['COUNT(*)'].'] | Views: '.$count_views['COUNT(*)'].' | <a title="Reports ['.$count_reports['COUNT(*)'].'/5]" href="/reports/?_type=1&_post='.$r['post_id'].'" style="color: red;">Report</a></div>';
	 echo '<div class="com_post">';
	$wynik2 = mysql_query("SELECT * FROM global_com WHERE com_value>'0' AND com_post_id='".$r['post_id']."' ORDER BY com_id DESC") or die('Błąd zapytania'); 
    if(mysql_num_rows($wynik2) > 0) { 
    while($r2 = mysql_fetch_assoc($wynik2)) { 
	$spr1i = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$r2['com_user_id']."'"));
    $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
    $r2['com_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $r2['com_desc']);
	echo '<div class="list_com"><a href="/profil/?user='.$spr1i['user_id'].'">'.$spr1i['user_nick'].'</a>: '.$r2['com_desc'].'</div>';
	}
	}else{
	
	}
	 echo '</div>';
     echo '</div>';
	 
	}
}

    echo '<div id="pager_bottom">';
    if($_GET['page']>0){
	$od_=$_GET['page']+1;
	$od_b=$_GET['page']-1;
    echo '<a href="/profil/?user='.$_GET['user'].'&page='.$od_b.'"> ⇐ BACK </a>';	
	$od_p=$_GET['page']*5+5;
	$_sp = mysql_query("SELECT * FROM global_post WHERE post_value>'0' AND post_user='".$post_user."' ORDER BY post_id DESC LIMIT ".$od_p.",5");
	if(mysql_num_rows($_sp)>0){
		
		
	
	echo '|';	
	echo '<a href="/profil/?user='.$_GET['user'].'&page='.$od_.'"> NEXT ⇒ </a>';
	}
	}else{
	echo '<a href="/profil/?user='.$_GET['user'].'&page=1"> NEXT ⇒ </a>';	
	}
    echo '</div>';

?>



</div>
</div>

<?php include('../in/footer.php'); ?>


</body>
</html>
















