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
<script>
    $("#search")
    .on("input", function () {
    $("#results td")
    .hide()
    .filter(function () {
    return $(this).text().toLowerCase().indexOf($("#search").val().toLowerCase()) >= 0;
    })
    .show();
    });
</script>
</head>
<body id="global">
<?php include('../in/top_menu.php'); ?>


<div id="center_body">
<div id="in_center_body">






<?php

echo '<div style="text-align: center;margin-bottom: 20px;">';
echo '<h3>Wyszukaj</h3>';
echo '<form method="post" action="/cars_info/?a=search"><input class="input_1" value="'.$_GET['search'].'" name="search" type="text" placeholder="Wpisz fraze ..."><button type="submit" class="button_1"><i class="fa fa-search" aria-hidden="true"></i></button></form>';
echo '</div>';
if($_GET['show']){
$_sellect_car = mysql_fetch_array(mysql_query("SELECT * FROM cars_info WHERE car_id='".$_GET['show']."'"));	
$_car_type = mysql_fetch_array(mysql_query("SELECT * FROM cars_type WHERE type_id='".$_sellect_car['car_type']."'"));
echo '<div style="font-size: 32px;text-align: center;padding: 10px;font-weight: 700;">'.$_sellect_car['car_name'].'</div>';	
echo '<div><img src="'.$_sellect_car['car_img'].'" width="100%"></div>';	
echo '<table>';
        echo '<tr>';	
		echo '<th>Nazwa pojazdu</th>';
        echo '<th>Podatek</th>';
        echo '<th>Vmax</th>';
        echo '<th>Vmax MK2</th>';
        echo '<th>Vmax MK3</th>';
        echo '<th>Vmax MK23</th>';
		echo '</tr>';
		echo '<tr>';
		if($_sellect_car['car_slots']==0){
		echo '<td><div class="li_img_l"><font size="1px">('.$_car_type['type_name'].')</br>(Miejsca: nie określono)</font></td>';	
		}else{
		echo '<td><div class="li_img_l"><font size="1px">('.$_car_type['type_name'].')</br>(Miejsca: '.$_sellect_car['car_slots'].')</font></td>';	
		}
		$_sellect_car['car_pod'] = number_format($_sellect_car['car_pod'], 2, ',', ' ');
        echo '<td>'.$_sellect_car['car_pod'].' €</td>';	
        echo '<td>'.$_sellect_car['car_vmax'].' km/h</td>';
		echo '<td>'.$_sellect_car['car_vmaxmk2'].' km/h</td>';
		echo '<td>'.$_sellect_car['car_vmaxmk3'].' km/h</td>';
		echo '<td>'.$_sellect_car['car_vmaxfmk'].' km/h</td>';
        echo '</tr>';
echo '</table>';

echo '<div style="font-size: 32px;text-align: center;padding: 10px;font-weight: 700;">Dostępność na giełdzie</div>';	
$wynik = mysql_query("SELECT * FROM global_post WHERE post_value>'0' AND post_value<'4' AND post_car_name='".$_sellect_car['car_id']."' ORDER BY post_id DESC LIMIT 0,5") or die('Błąd zapytania');  	
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
}else{
echo '<div style="font-size: 25px;text-align: center;padding: 10px;font-weight: 700;">brak wyników ...</div>';	
}
echo '</div></div>';
echo '<div id="center_body"><div id="in_center_body">';
	// komentarze
	 
	if($_SESSION['user_id']){
    $ban = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_bans WHERE ban_user='".$_SESSION['user_id']."' AND ban_value=2"));
    if($ban['COUNT(*)']==0){
	
	
	echo '<form style="text-align: center;padding: 5px;" method="post" action="?show='.$_GET['show'].'&c=a&q='.$_GET['show'].'">'; 
	echo '<textarea maxlength="150" style="width: 600px;padding: 5px;" name="com_desc" placeholder="Tereść komentarza (max 150 znaków)"></textarea>';
    echo '<input type="submit" style="width: 100px;float: left;margin-top: 25px;" class="filebuton" value="Dodaj">';
    echo '</form>';	
	if($_GET['c']=='a'){
	$com_desc=$_POST['com_desc'];
	$com_data=date('Y-m-d H:i:s');
	if(strlen($com_desc)>2){
	mysql_query("INSERT INTO global_com SET com_user_id='".$_SESSION['user_id']."', com_data='$com_data', com_desc='$com_desc', com_value='1', com_post_id='".$_GET['show']."'");
	header("refresh:0;url=/cars_info/?show=".$_GET['show']);
	}
	}

	}else{
	$ban2 = mysql_fetch_array(mysql_query("SELECT * FROM global_bans WHERE ban_user='".$_SESSION['user_id']."' AND ban_value=2"));	
echo '<div class="panel_div error_">';
    echo '<div class="panel_head error">';
	    echo 'Brak uprawnień!';
	echo '</div>';
    echo '<div class="panel_body">';
        echo 'Niestety nie posiadasz uprawnień, aby dodać nowy komentarz!';
		echo '</br> Blokada wygasa: '.$ban2['ban_data_do'];
    echo '</div>';
echo '</div>';	
	}
	}
	
	echo '<div class="com_post">';
	$wynik2 = mysql_query("SELECT * FROM global_com WHERE com_value>'0' AND com_post_id='".$_GET['show']."' ORDER BY com_id DESC") or die('Błąd zapytania'); 
    if(mysql_num_rows($wynik2) > 0) { 
    while($r2 = mysql_fetch_assoc($wynik2)) { 
	$spr1i = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$r2['com_user_id']."'"));
    $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
    $r2['com_desc'] = preg_replace($url, '<a target="_blank" href="http$2://$4">$0</a>', $r2['com_desc']);	
	echo '<div class="list_com"><a href="/profil/?user='.$spr1i['user_id'].'">'.$spr1i['user_nick'].'</a>: '.$r2['com_desc'].'</div>';
	}
	}else{	
	echo '<div class="list_com"><a>BOTradek</a>: Ten post nie został jeszcze skomentowany.</div>';	
	}
	 echo '</div>';
     echo '</div>';	
}else{

if($_GET['a']=='search'){
$search=$_POST['search'];
Header("Location: /cars_info/?search=".$search);
}else{

echo '<table>';
echo '<tr>';
if($_GET['search']){
echo '<th><a href="/cars_info/?s=name&search='.$_GET['search'].'">Nazwa pojazdu</a> | <a href="/cars_info/?s=type">Typ</a></th>';
echo '<th><a href="/cars_info/?s=pod&search='.$_GET['search'].'">Podatek</a></th>';
echo '<th><a href="/cars_info/?s=vmax&search='.$_GET['search'].'">Vmax</a></th>';
echo '<th><a href="/cars_info/?s=vmaxmk2&search='.$_GET['search'].'">Vmax MK2</a></th>';
echo '<th><a href="/cars_info/?s=vmaxmk3&search='.$_GET['search'].'">Vmax MK3</a></th>';
echo '<th><a href="/cars_info/?s=vmaxfmk&search='.$_GET['search'].'">Vmax MK23</a></th>';	
}else{
echo '<th><a href="/cars_info/?s=name">Nazwa pojazdu</a> | <a href="/cars_info/?s=type">Typ</a></th>';
echo '<th><a href="/cars_info/?s=pod">Podatek</a></th>';
echo '<th><a href="/cars_info/?s=vmax">Vmax</a></th>';
echo '<th><a href="/cars_info/?s=vmaxmk2">Vmax MK2</a></th>';
echo '<th><a href="/cars_info/?s=vmaxmk3">Vmax MK3</a></th>';
echo '<th><a href="/cars_info/?s=vmaxfmk">Vmax MK23</a></th>';
}
echo '</tr>';
if($_SESSION['zapytanie']){}else{$_SESSION['zapytanie']='car_name DESC';Header("Location: /cars_info/");}
if($_GET['s']=='type'){
	if($_SESSION['zapytanie']=='car_type DESC'){
	$_SESSION['zapytanie']='car_type ASC';	
	}else{
	$_SESSION['zapytanie']='car_type DESC';
	}
	if($_GET['search']){
	Header("Location: /cars_info/?search=".$_GET['search']);
	}else{
	Header("Location: /cars_info/");	
	}
	}
if($_GET['s']=='vmaxfmk'){
	if($_SESSION['zapytanie']=='car_vmaxfmk DESC'){
	$_SESSION['zapytanie']='car_vmaxfmk ASC';	
	}else{
	$_SESSION['zapytanie']='car_vmaxfmk DESC';
	}
	if($_GET['search']){
	Header("Location: /cars_info/?search=".$_GET['search']);
	}else{
	Header("Location: /cars_info/");	
	}
	}
if($_GET['s']=='vmaxmk3'){
	if($_SESSION['zapytanie']=='car_vmaxmk3 DESC'){
	$_SESSION['zapytanie']='car_vmaxmk3 ASC';	
	}else{
	$_SESSION['zapytanie']='car_vmaxmk3 DESC';
	}
	if($_GET['search']){
	Header("Location: /cars_info/?search=".$_GET['search']);
	}else{
	Header("Location: /cars_info/");	
	}
	}
if($_GET['s']=='vmaxmk2'){
	if($_SESSION['zapytanie']=='car_vmaxmk2 DESC'){
	$_SESSION['zapytanie']='car_vmaxmk2 ASC';	
	}else{
	$_SESSION['zapytanie']='car_vmaxmk2 DESC';
	}
	if($_GET['search']){
	Header("Location: /cars_info/?search=".$_GET['search']);
	}else{
	Header("Location: /cars_info/");	
	}
	}
if($_GET['s']=='vmax'){
	if($_SESSION['zapytanie']=='car_vmax DESC'){
	$_SESSION['zapytanie']='car_vmax ASC';	
	}else{
	$_SESSION['zapytanie']='car_vmax DESC';
	}
	if($_GET['search']){
	Header("Location: /cars_info/?search=".$_GET['search']);
	}else{
	Header("Location: /cars_info/");	
	}
	}
if($_GET['s']=='pod'){
	if($_SESSION['zapytanie']=='car_pod DESC'){
	$_SESSION['zapytanie']='car_pod ASC';	
	}else{
	$_SESSION['zapytanie']='car_pod DESC';
	}
	if($_GET['search']){
	Header("Location: /cars_info/?search=".$_GET['search']);
	}else{
	Header("Location: /cars_info/");	
	}
	}
if($_GET['s']=='name'){	if($_SESSION['zapytanie']=='car_name DESC'){
	$_SESSION['zapytanie']='car_name ASC';	
	}else{
	$_SESSION['zapytanie']='car_name DESC';
	}
	if($_GET['search']){
	Header("Location: /cars_info/?search=".$_GET['search']);
	}else{
	Header("Location: /cars_info/");	
	}
	}

	
if($_GET['search']){
if($_SESSION['zapytanie']){
$_search=$_GET['search'];	
$wynik = mysql_query("SELECT * FROM cars_info WHERE (car_name LIKE '%$_search%') ORDER BY ".$_SESSION['zapytanie']."") or die('Błąd zapytania');
}else{
$_search=$_GET['search'];
$wynik = mysql_query("SELECT * FROM cars_info WHERE (car_name LIKE '%$_search%') ") or die('Błąd zapytania');	
}		
}else{
if($_SESSION['zapytanie']){
$wynik = mysql_query("SELECT * FROM cars_info ORDER BY ".$_SESSION['zapytanie']."") or die('Błąd zapytania');
}else{
$wynik = mysql_query("SELECT * FROM cars_info") or die('Błąd zapytania');	
}		
}	



    while($r = mysql_fetch_assoc($wynik)) {
		$_car_type = mysql_fetch_array(mysql_query("SELECT * FROM cars_type WHERE type_id='".$r['car_type']."'"));
		echo '<tr>';
		if($r['car_slots']==0){
		echo '<td><div class="li_img_l"><img src="'.$r['car_img'].'" width="50px" height="50px"></div><b><a href="/cars_info/?show='.$r['car_id'].'">'.$r['car_name'].'</a></b></br><font size="1px">('.$_car_type['type_name'].')</br>(Miejsca: nie określono)</font></td>';	
		}else{
		echo '<td><div class="li_img_l"><img src="'.$r['car_img'].'" width="50px" height="50px"></div><b><a href="/cars_info/?show='.$r['car_id'].'">'.$r['car_name'].'</a></b></br><font size="1px">('.$_car_type['type_name'].')</br>(Miejsca: '.$r['car_slots'].')</font></td>';	
		}
		$r['car_pod'] = number_format($r['car_pod'], 2, ',', ' ');
        echo '<td>'.$r['car_pod'].' €</td>';	
        echo '<td>'.$r['car_vmax'].' km/h</td>';
		echo '<td>'.$r['car_vmaxmk2'].' km/h</td>';
		echo '<td>'.$r['car_vmaxmk3'].' km/h</td>';
		echo '<td>'.$r['car_vmaxfmk'].' km/h</td>';
        echo '</tr>';
	}
echo '</table>';
}
}
?>





</div>
</div>

<?php include('../in/footer.php'); ?>

</body>
</html>
















