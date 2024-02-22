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
echo '<form method="post" action="/tune_info/?a=search"><input class="input_1" value="'.$_GET['search'].'" name="search" type="text" placeholder="Wpisz fraze ..."><button type="submit" class="button_1"><i class="fa fa-search" aria-hidden="true"></i></button></form>';
echo '</div>';


if($_GET['a']=='search'){
$search=$_POST['search'];
Header("Location: /tune_info/?search=".$search);
}else{

echo '<table>';
echo '<tr>';
if($_GET['search']){
echo '<th><a href="/tune_info/?s=name&search='.$_GET['search'].'">Nazwa tuningu</a></th>';
echo '<th><a href="/tune_info/?s=cost&search='.$_GET['search'].'">Cena tuningu</a></th>';
echo '<th><a href="/tune_info/?s=decost&search='.$_GET['search'].'">Demont</a></th>';
echo '<th><a href="/tune_info/?s=pid&search='.$_GET['search'].'">Tune id</a></th>';
echo '<th><a href="/tune_info/?s=car&search='.$_GET['search'].'">Dostępność</a></th>';
}else{
echo '<th><a href="/tune_info/?s=name">Nazwa tuningu</a></th>';
echo '<th><a href="/tune_info/?s=cost">Cena tuningu</a></th>';
echo '<th><a href="/tune_info/?s=decost">Demont</a></th>';
echo '<th><a href="/tune_info/?s=pid">Tune id</a></th>';
echo '<th><a href="/tune_info/?s=car">Dostępność</a></th>';
}
echo '</tr>';
if($_SESSION['2zapytanie']){}else{$_SESSION['2zapytanie']='tune_name DESC';Header("Location: /tune_info/");}
if($_GET['s']=='name'){	if($_SESSION['2zapytanie']=='tune_name DESC'){
	$_SESSION['2zapytanie']='tune_name ASC';	
	}else{
	$_SESSION['2zapytanie']='tune_name DESC';
	}
	if($_GET['search']){
	Header("Location: /tune_info/?search=".$_GET['search']);
	}else{
	Header("Location: /tune_info/");	
	}
	}
if($_GET['s']=='cost'){
	if($_SESSION['2zapytanie']=='tune_cost DESC'){
	$_SESSION['2zapytanie']='tune_cost ASC';	
	}else{
	$_SESSION['2zapytanie']='tune_cost DESC';
	}
	if($_GET['search']){
	Header("Location: /tune_info/?search=".$_GET['search']);
	}else{
	Header("Location: /tune_info/");	
	}
	}
if($_GET['s']=='decost'){
	if($_SESSION['2zapytanie']=='tune_decost DESC'){
	$_SESSION['2zapytanie']='tune_decost ASC';	
	}else{
	$_SESSION['2zapytanie']='tune_decost DESC';
	}
	if($_GET['search']){
	Header("Location: /tune_info/?search=".$_GET['search']);
	}else{
	Header("Location: /tune_info/");	
	}
	}
if($_GET['s']=='pid'){
	if($_SESSION['2zapytanie']=='tune_pid DESC'){
	$_SESSION['2zapytanie']='tune_pid ASC';	
	}else{
	$_SESSION['2zapytanie']='tune_pid DESC';
	}
	if($_GET['search']){
	Header("Location: /tune_info/?search=".$_GET['search']);
	}else{
	Header("Location: /tune_info/");	
	}
	}
if($_GET['s']=='car'){
	if($_SESSION['2zapytanie']=='tune_car DESC'){
	$_SESSION['2zapytanie']='tune_car ASC';	
	}else{
	$_SESSION['2zapytanie']='tune_car DESC';
	}
	if($_GET['search']){
	Header("Location: /tune_info/?search=".$_GET['search']);
	}else{
	Header("Location: /tune_info/");	
	}
	}


	
if($_GET['search']){
if($_SESSION['2zapytanie']){
$_search=$_GET['search'];	
$wynik = mysql_query("SELECT * FROM tune_info WHERE (tune_name LIKE '%$_search%') ORDER BY ".$_SESSION['2zapytanie']."") or die('Błąd zapytania');
}else{
$_search=$_GET['search'];
$wynik = mysql_query("SELECT * FROM tune_info WHERE (tune_name LIKE '%$_search%') ") or die('Błąd zapytania');	
}		
}else{
if($_SESSION['2zapytanie']){
$wynik = mysql_query("SELECT * FROM tune_info ORDER BY ".$_SESSION['2zapytanie']."") or die('Błąd zapytania');
}else{
$wynik = mysql_query("SELECT * FROM tune_info") or die('Błąd zapytania');	
}		
}	



    while($r = mysql_fetch_assoc($wynik)) {
		$_car_tune = mysql_fetch_array(mysql_query("SELECT * FROM cars_info WHERE car_id='".$r['tune_car']."'"));
		echo '<tr>';
		if($r['car_slots']==0){
		echo '<td><b>'.$r['tune_name'].'</b></td>';	
		}else{
		echo '<td><b>'.$r['tune_name'].'</b></td>';	
		}
		$r['tune_cost'] = number_format($r['tune_cost'], 2, '.', ' ');
        echo '<td>'.$r['tune_cost'].' €</td>';
        $r['tune_decost'] = number_format($r['tune_decost'], 2, '.', ' ');		
        echo '<td>'.$r['tune_decost'].' €</td>';
		if($r['tune_pid']==0){
		echo '<td>n/a</td>';	
		}else{
		echo '<td>'.$r['tune_pid'].'</td>';	
		}
		if($r['tune_car']==0){
		echo '<td><i style="color: red;" class="fa fa-times" aria-hidden="true"></i> brak</td>';	
		}else{
		echo '<td><i style="color: green;" class="fa fa-check" aria-hidden="true"></i> dostępne</td>';	
		}
		

        echo '</tr>';
	}
echo '</table>';
}

?>





</div>
</div>

<?php include('../in/footer.php'); ?>

</body>
</html>
















