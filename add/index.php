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

$ban = mysql_fetch_array(mysql_query("SELECT * FROM global_bans WHERE ban_user='".$_SESSION['user_id']."'"));	
if($ban['ban_value']==0){

echo '<div class="panel_div warning_">';
    echo '<div class="panel_head warning">';
	    echo 'Uwaga!';
	echo '</div>';
    echo '<div class="panel_body">';
        echo 'Pamiętaj o zapełnieniu wszystkich pól, jest to bardzo ważne!</br>';
		echo 'Dozwolone rozszerzenia plików to PNG, JPG, JPNG, obraz nie mogą ważyć więcej niż 1,5 MB';
    echo '</div>';
echo '</div>';


	
	
//dodawnie obrazków
error_reporting(E_ERROR | E_WARNING | E_PARSE);
function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
echo '<form style="text-align: center;" method="post" action="?p=a" enctype="multipart/form-data">'; 
    echo '<select class="sellect" name="post_value">';
    echo '<option value="1">Aukcja: Kup teraz</option>';
    echo '<option value="2">Aukcja: Licytacja</option>';
    echo '</select>';    
	echo '<select class="sellect" name="post_car_name">';
	$wynik = mysql_query("SELECT * FROM cars_info") or die('Błąd zapytania'); 	
    while($r = mysql_fetch_assoc($wynik)) { 
	$r['car_pod'] = number_format($r['car_pod']);
	echo '<option value="'.$r['car_id'].'">'.$r['car_name'].' - ('.$r['car_pod'].'€)</option>';
	}
    echo '</select>';  
	echo '<input type="text" name="post_car_kp" placeholder="Przebieg pojazdu" class="sale_1" maxlength="6">';
	echo '<input type="text" name="post_car_id" placeholder="Dokładne id poajzdu" class="sale_1" maxlength="6">';
	echo '<input type="text" name="post_car_cost" placeholder="Cena *Kup Teraz* pojazdu" class="sale_1" maxlength="7">';
	echo '<input type="text" name="post_car_scost" placeholder="Cena startowa *licytacji*" class="sale_1" maxlength="7">';
	echo '<input type="text" name="post_car_tune" placeholder="Tuning pojazdu" class="sale_3">';
	echo '<input type="text" name="post_car_visu" placeholder="Wizualny tuning pojazdu" class="sale_3">';
	echo '<textarea maxlength="150" style="width: 600px;padding: 5px;" name="post_desc" placeholder="Opis postu (max 150 znaków)"></textarea><br>';
    echo '<input type="file" class="file" name="plik[]" multiple><br>';
    echo '<input type="submit" class="submit" value="Dodaj nowe ogłoszenie">';
echo '</form>';
if($_GET['p'] == 'a'){
	$post_desc = $_POST['post_desc'];
    $post_data = date('Y-m-d H:i:s');	
	$post_car_name = $_POST['post_car_name'];
	$post_car_kp = $_POST['post_car_kp'];
	$post_car_id = $_POST['post_car_id'];
	$post_car_cost = $_POST['post_car_cost'];
	$post_car_scost = $_POST['post_car_scost'];
	$post_car_tune = $_POST['post_car_tune'];
	$post_car_visu = $_POST['post_car_visu'];	
	
    mysql_query("INSERT INTO global_post SET post_user='".$_SESSION['user_id']."', post_data='$post_data', post_desc='$post_desc', post_car_name='$post_car_name', post_car_kp='$post_car_kp', post_car_id='$post_car_id', post_car_cost='$post_car_cost', post_car_scost='$post_car_scost', post_car_tune='$post_car_tune', post_car_visu='$post_car_visu', post_type='1', post_value='0'");
 

	$spr1a = mysql_fetch_array(mysql_query("SELECT * FROM global_post ORDER BY post_id DESC"));
	$_nowe_id=$spr1a['post_id'];

    $file_ary = reArrayFiles($_FILES['plik']);
    foreach($file_ary as $file){           
        $img_name=$file['name']; // nazwa pliku
        $p_roz = pathinfo($img_name, PATHINFO_EXTENSION);
        $p_nazwa_zm=uniqid().".".$p_roz;
        $folder="temp/";
		$rozmiar=$file['size'];
		

        if($p_roz == 'png' OR $p_roz == 'jpg' OR $p_roz == 'jpng'){
			if($rozmiar <= '1572864'){				
            if(move_uploaded_file($file['tmp_name'], $folder.$p_nazwa_zm)) {
              mysql_query("INSERT INTO global_users_files SET file_user_id='".$_SESSION['user_id']."', file_post_id='".$_nowe_id."', file_url='".'/add/'.$folder.$p_nazwa_zm."'");
			  header('Location: /waiting/'); 		  
             }else{
             echo "Błąd podczas uploadu pliku: ".$p_nazwa_zm;
             }
			 }else{
				 mysql_query("DELETE FROM global_post WHERE post_id='".$_nowe_id."'");
				 echo 'Przekroczono maksymalny rozmiar jednego pliku! </br>';
			}  	
	}else{header("Location: /add/");}
	
		

		
        }
    }

//koniec dodawania obrazków


	
}else{
echo '<div class="panel_div error_">';
    echo '<div class="panel_head error">';
	    echo 'Brak uprawnień!';
	echo '</div>';
    echo '<div class="panel_body">';
        echo 'Niestety nie posiadasz uprawnień, aby zobaczyć tę stronę!';
		echo '</br> Blokada wygasa: '.$ban['ban_data_do'];
    echo '</div>';
echo '</div>';	
$_spr_x=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_bans WHERE ban_user='".$_SESSION['user_id']."' AND ban_data_do<NOW() AND ban_value='1'"));
if($_spr_x['COUNT(*)']==1){
mysql_query("DELETE FROM global_bans WHERE ban_user='".$_SESSION['user_id']."' AND ban_data_do<NOW() AND ban_value='1'"); 
header('Location: /add/'); 
}
}		
}else{
echo '<div class="panel_div error_">';
    echo '<div class="panel_head error">';
	    echo 'Wymagamy autoryzacji!';
	echo '</div>';
    echo '<div class="panel_body">';
        echo 'Aby dodać nowy post, musisz się zalogować za pomocą konta.</br>';

    echo '</div>';
echo '</div>';	
}


?>


</div>
</div>

<?php include('../in/footer.php'); ?>


</body>
</html>
















