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


<div id="center_body_2">
<div id="in_center_body">
<h1 style="text-align: center;">Reporting Center BETA 1.0</h1>
<?php

if($_GET['_type']==1){
$_a = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id='".$_GET['_post']."'"));
$_b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$_a['post_user']."'"));
echo '<h2 style="text-align: center;">Post raporting</h2>';	
echo '<center>';
echo 'User: '.$_b['user_nick'];
echo '</br>';
echo '<p>Post zawiera treść lub obraz łamiący regulamin,</br> prawa autorskie lub inny czynnik wpływający na niekorzyść autora.</p>';
echo '<p>The post contains content or a picture that breaks the rules,</br> copyright or other factor affecting the author\'s unevenness.</p>';
echo '</br>';
echo '<a href="/reports/?send_p=ok&_post='.$_GET['_post'].'" style="text-decoration: none;"><div class="_button_">Send Report</div></a>';
echo '</br>';
echo '<a href="/post/?q='.$_GET['_post'].'">cancel</a>';
echo '</br>';
echo '</center>';
}

if($_GET['send_p']=='ok'){
$_f = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_reports WHERE report_post_id='".$_GET['_post']."'"));
if($_f['COUNT(*)'] == 14){
$_c = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_reports WHERE report_ip='".$_SERVER['REMOTE_ADDR']."' AND report_data>NOW() AND report_post_id='".$_GET['_post']."'"));	
if($_c['COUNT(*)']==1){
echo '<h2 style="text-align: center;">Post raporting: NO SEND!</h2>';	
echo '<center>';
echo '<h2>Raport nie wysłany, odczekaj od poprzedniego raportowania.</h2>';
echo '<h2>Report not sent, wait from previous reporting.</h2>';
echo '</center>';	
}else{
$_d = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id='".$_GET['_post']."'"));
$_e = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$_d['post_user']."'"));
$count_reports = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_reports WHERE report_post_id='".$_GET['_post']."'"));

$start = date('Y-m-d H:i:s');
$ts = strtotime($start);
if (date('Y-m-d H:i:s', $ts) != $start)
throw new Exception('Błąd konwersji');
$report_data = date('Y-m-d H:i:s', strtotime('+24 hour', $ts));			
$report_post_id=$_GET['_post'];
$report_codid=uniqid();	
$report_ip=$_SERVER['REMOTE_ADDR'];
mysql_query("INSERT INTO global_reports SET report_post_id='$report_post_id', report_data='$report_data', report_codid='$report_codid', report_ip='$report_ip'")or die('Brak połączenia z serwerem MySQL. <br />Błąd: '.mysql_error()); 


echo '<h2 style="text-align: center;">Post raporting: SEND!</h2>';	
echo '<center>';
echo '<h2>Report CODID: '.$report_codid.'</h2>';
echo '</center>';
$count_reports['COUNT(*)']=$count_reports['COUNT(*)']+1;
$pow_text = 'Twój <a target="_blank" href="/post/?q='.$_GET['_post'].'">post</a> otrzymał raport ['.$count_reports['COUNT(*)'].'/15] „Post zawiera treść lub obraz łamiący regulamin, prawa autorskie lub inny czynnik wpływający na niekorzyść autora”.</br>Otrzymanie 15 raportów skutkuje zablokowaniem posta.';
$pow_icon = 'fa fa-exclamation-triangle';
$pow_data = date('Y-m-d H:i:s');
mysql_query("INSERT INTO global_pow SET pow_user_id='".$_e['user_id']."', pow_text='$pow_text', pow_icon='$pow_icon', pow_value='0', pow_type='2', pow_data='$pow_data', pow_ck='0'")or die('Brak połączenia z serwerem MySQL. <br />Błąd: '.mysql_error());


}	
	
$_d = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id='".$_GET['_post']."'"));
$_e = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$_d['post_user']."'"));	
$pow_text = 'Twój <a target="_blank" href="/post/?q='.$_GET['_post'].'">post</a> został usunięty ze względów: „Post zawiera treść lub obraz łamiący regulamin, prawa autorskie lub inny czynnik wpływający na niekorzyść autora”. Otrzymujesz siedmiodniową (7d) blokadę ograniczającą na konto.';
$pow_icon = 'fa fa-ban';
$pow_data = date('Y-m-d H:i:s');
mysql_query("INSERT INTO global_pow SET pow_user_id='".$_e['user_id']."', pow_text='$pow_text', pow_icon='$pow_icon', pow_value='0', pow_type='3', pow_data='$pow_data', pow_ck='0'")or die('Brak połączenia z serwerem MySQL. <br />Błąd: '.mysql_error());

$start = date('Y-m-d H:i:s');
$ts = strtotime($start);
if (date('Y-m-d H:i:s', $ts) != $start)
throw new Exception('Błąd konwersji');
$ban_data = date('Y-m-d H:i:s', strtotime('+7 days', $ts));		

mysql_query("INSERT INTO global_bans SET ban_user_id='".$_e['user_id']."', ban_com='0', ban_post='1', ban_etc='0', ban_data='$ban_data'")or die('Brak połączenia z serwerem MySQL. <br />Błąd: '.mysql_error());
//usuwamy post
mysql_query("DELETE FROM global_post WHERE post_id='".$_GET['_post']."'"); 
$pre = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id='".$_GET['_post']."'")); 
mysql_query("DELETE FROM global_users_files WHERE file_post_id='".$_GET['_post']."'");  	
}else{
$_c = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_reports WHERE report_ip='".$_SERVER['REMOTE_ADDR']."' AND report_data>NOW() AND report_post_id='".$_GET['_post']."'"));	
if($_c['COUNT(*)']==1){
echo '<h2 style="text-align: center;">Post raporting: NO SEND!</h2>';	
echo '<center>';
echo '<h2>Raport nie wysłany, odczekaj od poprzedniego raportowania.</h2>';
echo '<h2>Report not sent, wait from previous reporting.</h2>';
echo '</center>';	
}else{
$_d = mysql_fetch_array(mysql_query("SELECT * FROM global_post WHERE post_id='".$_GET['_post']."'"));
$_e = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$_d['post_user']."'"));
$count_reports = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_reports WHERE report_post_id='".$_GET['_post']."'"));

$start = date('Y-m-d H:i:s');
$ts = strtotime($start);
if (date('Y-m-d H:i:s', $ts) != $start)
throw new Exception('Błąd konwersji');
$report_data = date('Y-m-d H:i:s', strtotime('+24 hour', $ts));			
$report_post_id=$_GET['_post'];
$report_codid=uniqid();	
$report_ip=$_SERVER['REMOTE_ADDR'];
mysql_query("INSERT INTO global_reports SET report_post_id='$report_post_id', report_data='$report_data', report_codid='$report_codid', report_ip='$report_ip'")or die('Brak połączenia z serwerem MySQL. <br />Błąd: '.mysql_error()); 

echo '<h2 style="text-align: center;">Post raporting: SEND!</h2>';	
echo '<center>';
echo '<h2>Report CODID: '.$report_codid.'</h2>';
echo '</center>';
$count_reports['COUNT(*)']=$count_reports['COUNT(*)']+1;
$pow_text = 'Twój <a target="_blank" href="/post/?q='.$_GET['_post'].'">post</a> otrzymał raport ['.$count_reports['COUNT(*)'].'/15] „Post zawiera treść lub obraz łamiący regulamin, prawa autorskie lub inny czynnik wpływający na niekorzyść autora”.</br>Otrzymanie 15 raportów skutkuje zablokowaniem posta.';
$pow_icon = 'fa fa-exclamation-triangle';
$pow_data = date('Y-m-d H:i:s');
mysql_query("INSERT INTO global_pow SET pow_user_id='".$_e['user_id']."', pow_text='$pow_text', pow_icon='$pow_icon', pow_value='0', pow_type='2', pow_data='$pow_data', pow_ck='0'")or die('Brak połączenia z serwerem MySQL. <br />Błąd: '.mysql_error()); 
}
}
}


?>



</div>
</div>

<?php //include('../in/footer.php'); ?>


</body>
</html>

