<?php include('../dbcon.php'); session_start(); ?>
<!doctype html>
<html lang="pl">
<head>
<!-- Strefa HEAD -->

<!-- Opis, tytuł, autor, kodowanie -->
<title>Online Cars for Sale!</title>
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

<?php
	if($_GET['page']>0){
	$od_p=$_GET['page']*5;	
	$wynik = mysql_query("SELECT * FROM global_post WHERE post_value>'0' AND post_value<'4' ORDER BY post_id DESC LIMIT ".$od_p.",5") or die('Błąd zapytania'); 	
	}else{
	$wynik = mysql_query("SELECT * FROM global_post WHERE post_value>'0' AND post_value<'4' ORDER BY post_id DESC LIMIT 0,5") or die('Błąd zapytania'); 	
	}
if(mysql_num_rows($wynik) > 0) { 
    while($r = mysql_fetch_assoc($wynik)) { 
	 //while posty
	 $spr1b = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$r['post_user']."'"));
     echo '<div class="list_post">';
	 


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
</table>
	 
	 </div>
	 </div>';
     echo '<div style="clear: both;"></div>';

     echo '</div>';

	}
}

    echo '<div id="pager_bottom">';
    if($_GET['page']>0){
	$od_=$_GET['page']+1;
	$od_b=$_GET['page']-1;
    echo '<a href="/new/?page='.$od_b.'"> ⇐ BACK </a>';	
	$od_p=$_GET['page']*5+5;
	$_sp = mysql_query("SELECT * FROM global_post WHERE post_value>'0' ORDER BY post_id DESC LIMIT ".$od_p.",5");
	if(mysql_num_rows($_sp)>0){
		
		
	
	echo '|';	
	echo '<a href="/new/?page='.$od_.'"> NEXT ⇒ </a>';
	}
	}else{
	echo '<a href="/new/?page=1"> NEXT ⇒ </a>';	
	}
    echo '</div>';
	


?>



</div>
</div>

<?php include('../in/footer.php'); ?>


</body>
</html>
















