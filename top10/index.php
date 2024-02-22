<?php include('../dbcon.php'); session_start(); ?>
<!doctype html>
<html lang="pl">
<head>
<!-- Strefa HEAD -->

<!-- Opis, tytuł, autor, kodowanie -->
<title>Online Cars for Sale!</title>
<meta charset="utf-8">
<meta name="description" content="Giełda online, kupuj, sprzedawaj pojazdy!">
<meta name="author" content="Iron_NOW, OKTAS.as, Ajon">
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
	    echo 'Najlepsze 10 postów.';
	echo '</div>';
    echo '<div class="panel_body">';
        echo '10 najlepszych postów jest wybierane z wyświetleń z ostatniego czasu, aktualnie ustawione są na 14 dni.';
    echo '</div>';
echo '</div>';

// numer 1 na top 10/////////////////////////////////////////////////////
$top10_1_c = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
if($top10_1_c['COUNT(*)']==0){}else{
$top10_1 = mysql_fetch_array(mysql_query("SELECT views_post_id FROM global_views GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
$top10_1_ = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id=".$top10_1['views_post_id'].""));
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$top10_1_['post_user']."'"));
     echo '<div class="post_content_1">';
	 echo '<div class="title_post">Numer #1</div>';
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$top10_1_['post_id']."'"));
     echo '<div class="image_post" style="float: left;"><a href="/post/?q='.$top10_1_['post_id'].'"><img src="'.$spr1c['file_url'].'" title="'.$top10_1_['post_title'].'" width="100px" height="100px"></img></a></div>';
	 $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
     $top10_1_['post_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $top10_1_['post_desc']);
	 echo '<div class="desc_post" style="margin-left: 100px;">'.$top10_1_['post_desc'].'</div>';
     $czom_q = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_com WHERE com_value>'0' AND com_post_id='".$top10_1_['post_id']."'"));
	 $count_views = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id='".$top10_1_['post_id']."'"));
     echo '<div class="info_post" style="float: left;">Dodano: '.$top10_1_['post_data'].' przez: <a href="/profil/?user='.$top10_1_['post_user'].'">'.$spr1b['user_nick'].'</a> | <a href="/post/?q='.$top10_1_['post_id'].'">Komentarze</a> ['.$czom_q['COUNT(*)'].'] | Views: '.$count_views['COUNT(*)'].'</div>';
	 echo '<div style="clear: both;"></div>';

     echo '</div>';
}
//////////////////////////////////////////////////////////////////////////

// numer 2 na top 10/////////////////////////////////////////////////////
$top10_2_c = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
if($top10_2_c['COUNT(*)']==0){}else{
$top10_2 = mysql_fetch_array(mysql_query("SELECT views_post_id FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
$top10_2_ = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id=".$top10_2['views_post_id'].""));
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$top10_2_['post_user']."'"));
     echo '<div class="post_content_1">';
	 echo '<div class="title_post">Numer #2</div>';
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$top10_2_['post_id']."'"));
     echo '<div class="image_post" style="float: left;"><a href="/post/?q='.$top10_2_['post_id'].'"><img src="'.$spr1c['file_url'].'" title="'.$top10_2_['post_title'].'" width="100px" height="100px"></img></a></div>';
	 $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
     $top10_2_['post_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $top10_2_['post_desc']);
	 echo '<div class="desc_post" style="margin-left: 100px;">'.$top10_2_['post_desc'].'</div>';
     $czom_q = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_com WHERE com_value>'0' AND com_post_id='".$top10_2_['post_id']."'"));
	 $count_views = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id='".$top10_2_['post_id']."'"));
     echo '<div class="info_post" style="float: left;">Dodano: '.$top10_2_['post_data'].' przez: <a href="/profil/?user='.$top10_2_['post_user'].'">'.$spr1b['user_nick'].'</a> | <a href="/post/?q='.$top10_2_['post_id'].'">Komentarze</a> ['.$czom_q['COUNT(*)'].'] | Views: '.$count_views['COUNT(*)'].'</div>';
	 echo '<div style="clear: both;"></div>';

     echo '</div>';
}
//////////////////////////////////////////////////////////////////////////

// numer 3 na top 10/////////////////////////////////////////////////////
$top10_3_c = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
if($top10_3_c['COUNT(*)']==0){}else{
$top10_3 = mysql_fetch_array(mysql_query("SELECT views_post_id FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
$top10_3_ = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id=".$top10_3['views_post_id'].""));
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$top10_3_['post_user']."'"));
     echo '<div class="post_content_1">';
	 echo '<div class="title_post">Numer #3</div>';
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$top10_3_['post_id']."'"));
     echo '<div class="image_post" style="float: left;"><a href="/post/?q='.$top10_3_['post_id'].'"><img src="'.$spr1c['file_url'].'" title="'.$top10_3_['post_title'].'" width="100px" height="100px"></img></a></div>';
	 $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
     $top10_3_['post_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $top10_3_['post_desc']);
	 echo '<div class="desc_post" style="margin-left: 100px;">'.$top10_3_['post_desc'].'</div>';
     $czom_q = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_com WHERE com_value>'0' AND com_post_id='".$top10_2_['post_id']."'"));
	 $count_views = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id='".$top10_3_['post_id']."'"));
     echo '<div class="info_post" style="float: left;">Dodano: '.$top10_3_['post_data'].' przez: <a href="/profil/?user='.$top10_3_['post_user'].'">'.$spr1b['user_nick'].'</a> | <a href="/post/?q='.$top10_3_['post_id'].'">Komentarze</a> ['.$czom_q['COUNT(*)'].'] | Views: '.$count_views['COUNT(*)'].'</div>';
	 echo '<div style="clear: both;"></div>';

     echo '</div>';
}
//////////////////////////////////////////////////////////////////////////

// numer 4 na top 10/////////////////////////////////////////////////////
$top10_4_c = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
if($top10_4_c['COUNT(*)']==0){}else{
$top10_4 = mysql_fetch_array(mysql_query("SELECT views_post_id FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
$top10_4_ = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id=".$top10_4['views_post_id'].""));
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$top10_4_['post_user']."'"));
     echo '<div class="post_content_1">';
	 echo '<div class="title_post">Numer #4</div>';
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$top10_4_['post_id']."'"));
     echo '<div class="image_post" style="float: left;"><a href="/post/?q='.$top10_4_['post_id'].'"><img src="'.$spr1c['file_url'].'" title="'.$top10_4_['post_title'].'" width="100px" height="100px"></img></a></div>';
	 $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
     $top10_4_['post_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $top10_4_['post_desc']);
	 echo '<div class="desc_post" style="margin-left: 100px;">'.$top10_4_['post_desc'].'</div>';
     $czom_q = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_com WHERE com_value>'0' AND com_post_id='".$top10_4_['post_id']."'"));
	 $count_views = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id='".$top10_4_['post_id']."'"));
     echo '<div class="info_post" style="float: left;">Dodano: '.$top10_4_['post_data'].' przez: <a href="/profil/?user='.$top10_4_['post_user'].'">'.$spr1b['user_nick'].'</a> | <a href="/post/?q='.$top10_4_['post_id'].'">Komentarze</a> ['.$czom_q['COUNT(*)'].'] | Views: '.$count_views['COUNT(*)'].'</div>';
	 echo '<div style="clear: both;"></div>';

     echo '</div>';
}
//////////////////////////////////////////////////////////////////////////

// numer 5 na top 10/////////////////////////////////////////////////////
$top10_5_c = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' AND views_post_id<>'".$top10_4['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
if($top10_5_c['COUNT(*)']==0){}else{
$top10_5 = mysql_fetch_array(mysql_query("SELECT views_post_id FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' AND views_post_id<>'".$top10_4['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
$top10_5_ = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id=".$top10_5['views_post_id'].""));
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$top10_5_['post_user']."'"));
     echo '<div class="post_content_1">';
	 echo '<div class="title_post">Numer #5</div>';
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$top10_5_['post_id']."'"));
     echo '<div class="image_post" style="float: left;"><a href="/post/?q='.$top10_5_['post_id'].'"><img src="'.$spr1c['file_url'].'" title="'.$top10_5_['post_title'].'" width="100px" height="100px"></img></a></div>';
	 $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
     $top10_5_['post_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $top10_5_['post_desc']);
	 echo '<div class="desc_post" style="margin-left: 100px;">'.$top10_5_['post_desc'].'</div>';
     $czom_q = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_com WHERE com_value>'0' AND com_post_id='".$top10_5_['post_id']."'"));
	 $count_views = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id='".$top10_5_['post_id']."'"));
     echo '<div class="info_post" style="float: left;">Dodano: '.$top10_5_['post_data'].' przez: <a href="/profil/?user='.$top10_5_['post_user'].'">'.$spr1b['user_nick'].'</a> | <a href="/post/?q='.$top10_5_['post_id'].'">Komentarze</a> ['.$czom_q['COUNT(*)'].'] | Views: '.$count_views['COUNT(*)'].'</div>';
	 echo '<div style="clear: both;"></div>';

     echo '</div>';
}
//////////////////////////////////////////////////////////////////////////

// numer 6 na top 10/////////////////////////////////////////////////////
$top10_6_c = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' AND views_post_id<>'".$top10_4['views_post_id']."' AND views_post_id<>'".$top10_5['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
if($top10_6_c['COUNT(*)']==0){}else{
$top10_6 = mysql_fetch_array(mysql_query("SELECT views_post_id FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' AND views_post_id<>'".$top10_4['views_post_id']."' AND views_post_id<>'".$top10_5['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
$top10_6_ = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id=".$top10_6['views_post_id'].""));
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$top10_6_['post_user']."'"));
     echo '<div class="post_content_1">';
	 echo '<div class="title_post">Numer #6</div>';
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$top10_6_['post_id']."'"));
     echo '<div class="image_post" style="float: left;"><a href="/post/?q='.$top10_6_['post_id'].'"><img src="'.$spr1c['file_url'].'" title="'.$top10_6_['post_title'].'" width="100px" height="100px"></img></a></div>';
	 $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
     $top10_6_['post_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $top10_6_['post_desc']);
	 echo '<div class="desc_post" style="margin-left: 100px;">'.$top10_6_['post_desc'].'</div>';
     $czom_q = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_com WHERE com_value>'0' AND com_post_id='".$top10_6_['post_id']."'"));
	 $count_views = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id='".$top10_6_['post_id']."'"));
     echo '<div class="info_post" style="float: left;">Dodano: '.$top10_6_['post_data'].' przez: <a href="/profil/?user='.$top10_6_['post_user'].'">'.$spr1b['user_nick'].'</a> | <a href="/post/?q='.$top10_6_['post_id'].'">Komentarze</a> ['.$czom_q['COUNT(*)'].'] | Views: '.$count_views['COUNT(*)'].'</div>';
	 echo '<div style="clear: both;"></div>';

     echo '</div>';
}
//////////////////////////////////////////////////////////////////////////

// numer 7 na top 10/////////////////////////////////////////////////////
$top10_7_c = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' AND views_post_id<>'".$top10_4['views_post_id']."' AND views_post_id<>'".$top10_5['views_post_id']."' AND views_post_id<>'".$top10_6['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
if($top10_7_c['COUNT(*)']==0){}else{
$top10_7 = mysql_fetch_array(mysql_query("SELECT views_post_id FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' AND views_post_id<>'".$top10_4['views_post_id']."' AND views_post_id<>'".$top10_5['views_post_id']."' AND views_post_id<>'".$top10_6['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
$top10_7_ = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id=".$top10_7['views_post_id'].""));
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$top10_7_['post_user']."'"));
     echo '<div class="post_content_1">';
	 echo '<div class="title_post">Numer #7</div>';
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$top10_7_['post_id']."'"));
     echo '<div class="image_post" style="float: left;"><a href="/post/?q='.$top10_7_['post_id'].'"><img src="'.$spr1c['file_url'].'" title="'.$top10_7_['post_title'].'" width="100px" height="100px"></img></a></div>';
	 $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
     $top10_7_['post_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $top10_7_['post_desc']);
	 echo '<div class="desc_post" style="margin-left: 100px;">'.$top10_7_['post_desc'].'</div>';
     $czom_q = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_com WHERE com_value>'0' AND com_post_id='".$top10_7_['post_id']."'"));
	 $count_views = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id='".$top10_7_['post_id']."'"));
     echo '<div class="info_post" style="float: left;">Dodano: '.$top10_7_['post_data'].' przez: <a href="/profil/?user='.$top10_7_['post_user'].'">'.$spr1b['user_nick'].'</a> | <a href="/post/?q='.$top10_7_['post_id'].'">Komentarze</a> ['.$czom_q['COUNT(*)'].'] | Views: '.$count_views['COUNT(*)'].'</div>';
	 echo '<div style="clear: both;"></div>';

     echo '</div>';
}
//////////////////////////////////////////////////////////////////////////

// numer 8 na top 10/////////////////////////////////////////////////////
$top10_8_c = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' AND views_post_id<>'".$top10_4['views_post_id']."' AND views_post_id<>'".$top10_5['views_post_id']."' AND views_post_id<>'".$top10_6['views_post_id']."'  AND views_post_id<>'".$top10_7['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
if($top10_8_c['COUNT(*)']==0){}else{
$top10_8 = mysql_fetch_array(mysql_query("SELECT views_post_id FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' AND views_post_id<>'".$top10_4['views_post_id']."' AND views_post_id<>'".$top10_5['views_post_id']."' AND views_post_id<>'".$top10_6['views_post_id']."'  AND views_post_id<>'".$top10_7['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
$top10_8_ = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id=".$top10_8['views_post_id'].""));
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$top10_8_['post_user']."'"));
     echo '<div class="post_content_1">';
	 echo '<div class="title_post">Numer #8</div>';
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$top10_8_['post_id']."'"));
     echo '<div class="image_post" style="float: left;"><a href="/post/?q='.$top10_8_['post_id'].'"><img src="'.$spr1c['file_url'].'" title="'.$top10_8_['post_title'].'" width="100px" height="100px"></img></a></div>';
	 $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
     $top10_8_['post_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $top10_8_['post_desc']);
	 echo '<div class="desc_post" style="margin-left: 100px;">'.$top10_8_['post_desc'].'</div>';
     $czom_q = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_com WHERE com_value>'0' AND com_post_id='".$top10_8_['post_id']."'"));
	 $count_views = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id='".$top10_8_['post_id']."'"));
     echo '<div class="info_post" style="float: left;">Dodano: '.$top10_8_['post_data'].' przez: <a href="/profil/?user='.$top10_8_['post_user'].'">'.$spr1b['user_nick'].'</a> | <a href="/post/?q='.$top10_8_['post_id'].'">Komentarze</a> ['.$czom_q['COUNT(*)'].'] | Views: '.$count_views['COUNT(*)'].'</div>';
	 echo '<div style="clear: both;"></div>';

     echo '</div>';
}
//////////////////////////////////////////////////////////////////////////

// numer 9 na top 10/////////////////////////////////////////////////////
$top10_9_c = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' AND views_post_id<>'".$top10_4['views_post_id']."' AND views_post_id<>'".$top10_5['views_post_id']."' AND views_post_id<>'".$top10_6['views_post_id']."'  AND views_post_id<>'".$top10_7['views_post_id']."' AND views_post_id<>'".$top10_8['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
if($top10_9_c['COUNT(*)']==0){}else{
$top10_9 = mysql_fetch_array(mysql_query("SELECT views_post_id FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' AND views_post_id<>'".$top10_4['views_post_id']."' AND views_post_id<>'".$top10_5['views_post_id']."' AND views_post_id<>'".$top10_6['views_post_id']."'  AND views_post_id<>'".$top10_7['views_post_id']."' AND views_post_id<>'".$top10_8['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
$top10_9_ = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id=".$top10_9['views_post_id'].""));
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$top10_9_['post_user']."'"));
     echo '<div class="post_content_1">';
	 echo '<div class="title_post">Numer #9</div>';
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$top10_9_['post_id']."'"));
     echo '<div class="image_post" style="float: left;"><a href="/post/?q='.$top10_9_['post_id'].'"><img src="'.$spr1c['file_url'].'" title="'.$top10_9_['post_title'].'" width="100px" height="100px"></img></a></div>';
	 $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
     $top10_9_['post_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $top10_9_['post_desc']);
	 echo '<div class="desc_post" style="margin-left: 100px;">'.$top10_9_['post_desc'].'</div>';
     $czom_q = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_com WHERE com_value>'0' AND com_post_id='".$top10_9_['post_id']."'"));
	 $count_views = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id='".$top10_9_['post_id']."'"));
     echo '<div class="info_post" style="float: left;">Dodano: '.$top10_9_['post_data'].' przez: <a href="/profil/?user='.$top10_9_['post_user'].'">'.$spr1b['user_nick'].'</a> | <a href="/post/?q='.$top10_9_['post_id'].'">Komentarze</a> ['.$czom_q['COUNT(*)'].'] | Views: '.$count_views['COUNT(*)'].'</div>';
	 echo '<div style="clear: both;"></div>';

     echo '</div>';
}
//////////////////////////////////////////////////////////////////////////

// numer 10 na top 10/////////////////////////////////////////////////////
$top10_10_c = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' AND views_post_id<>'".$top10_4['views_post_id']."' AND views_post_id<>'".$top10_5['views_post_id']."' AND views_post_id<>'".$top10_6['views_post_id']."'  AND views_post_id<>'".$top10_7['views_post_id']."' AND views_post_id<>'".$top10_8['views_post_id']."' AND views_post_id<>'".$top10_9['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
if($top10_10_c['COUNT(*)']==0){}else{
$top10_10 = mysql_fetch_array(mysql_query("SELECT views_post_id FROM global_views WHERE views_post_id<>'".$top10_1['views_post_id']."' AND views_post_id<>'".$top10_2['views_post_id']."' AND views_post_id<>'".$top10_3['views_post_id']."' AND views_post_id<>'".$top10_4['views_post_id']."' AND views_post_id<>'".$top10_5['views_post_id']."' AND views_post_id<>'".$top10_6['views_post_id']."'  AND views_post_id<>'".$top10_7['views_post_id']."' AND views_post_id<>'".$top10_8['views_post_id']."' AND views_post_id<>'".$top10_9['views_post_id']."' GROUP BY views_post_id ORDER BY COUNT(views_post_id) DESC"));
$top10_10_ = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id=".$top10_10['views_post_id'].""));
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$top10_10_['post_user']."'"));
     echo '<div class="post_content_1">';
	 echo '<div class="title_post">Numer #10</div>';
	 $spr1c = mysql_fetch_array(mysql_query("SELECT * FROM global_users_files WHERE file_post_id='".$top10_10_['post_id']."'"));
     echo '<div class="image_post" style="float: left;"><a href="/post/?q='.$top10_10_['post_id'].'"><img src="'.$spr1c['file_url'].'" title="'.$top10_10_['post_title'].'" width="100px" height="100px"></img></a></div>';
	 $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
     $top10_10_['post_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $top10_10_['post_desc']);
	 echo '<div class="desc_post" style="margin-left: 100px;">'.$top10_10_['post_desc'].'</div>';
     $czom_q = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_com WHERE com_value>'0' AND com_post_id='".$top10_10_['post_id']."'"));
	 $count_views = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_views WHERE views_post_id='".$top10_10_['post_id']."'"));
     echo '<div class="info_post" style="float: left;">Dodano: '.$top10_10_['post_data'].' przez: <a href="/profil/?user='.$top10_10_['post_user'].'">'.$spr1b['user_nick'].'</a> | <a href="/post/?q='.$top10_10_['post_id'].'">Komentarze</a> ['.$czom_q['COUNT(*)'].'] | Views: '.$count_views['COUNT(*)'].'</div>';
	 echo '<div style="clear: both;"></div>';

     echo '</div>';
}
//////////////////////////////////////////////////////////////////////////


?>



</div>
</div>

<?php include('../in/footer.php'); ?>


</body>
</html>
















