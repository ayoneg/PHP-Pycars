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
<h1>Powiadomienia</h1>
<?php

if($_SESSION['user_id']){
mysql_query("UPDATE global_pow SET pow_ck='1' WHERE pow_user_id='".$_SESSION['user_id']."'");  	
	
	
$wynik = mysql_query("SELECT * FROM global_pow WHERE pow_user_id='".$_SESSION['user_id']."' AND pow_value='0' ORDER BY pow_id DESC") or die('Błąd zapytania'); 	
if(mysql_num_rows($wynik) > 0) { 
while($r = mysql_fetch_assoc($wynik)) {
echo '<div class="pow_list p_color_'.$r['pow_type'].'">';
    echo '<div class="_p"><i class="'.$r['pow_icon'].'" aria-hidden="true"></i> '.$r['pow_data'].'</div>';
	echo '<div class="_p_">'.$r['pow_text'].'</div>';
	echo '<div class="__clear-both"></div>';
echo '</div>';	
}
} else {
echo '<div class="pow_list p_color_1">';
    echo '<div class="_p"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></div>';
	echo '<div class="_p_">Nie masz żadnych powiadomień!</div>';
	echo '<div class="__clear-both"></div>';
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

