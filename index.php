<?php include('dbcon.php'); session_start(); ?>
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
<?php include('in/top_menu.php'); ?>


<div id="center_body">
<div id="in_center_body" style="margin: 10px;">
<?php if($_GET['log']=='a' OR $_GET['new']=='account'){}else{
if($_GET['log']=='out'){session_destroy();Header("Location: /");}


$licz_1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_post WHERE post_value>'0' AND post_value<'4'"));
$licz_2 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_post WHERE post_value='5' OR post_value='6'"));
echo '<div style="font-size: 35px;text-align: center;padding: 10px;font-weight: 700;">Giełda Online!</div>';	


?>
<p style="color: green;">Naprawdę bardzo dziękuje wszystkim osobą odwiedzającym stronę, za wasze opinie przesłana w grze, jak i na forum! Dzięki wam udoskonalam stronę, by mogli z tego korzystać inni!
Wielkie dzięki // ajon :)</p>
<p><center><img style="float: left;" src="/images/bin/img-pycars-001.png" height="100%"></center></p>
<p style="margin-left: 340px;">Oto procent posiadania danego rodzaju felg, statystyki zebrane tylko z giełdy w LV w godzinie 1:00,  dnia 16 lipca 2018 roku.</br> Z tych statystyk wynika, że najpopularniej montowanymi felgami są Ahaby! Natomiast offroady stanowią tylko 13,27% wszystkich felg, najmniej montowanych jest Dollarów, bo mają one zaledwie 1 sztukę na 113 aut.</p>
<p style="margin-left: 340px;">Witam wszystkich bardzo serdecznie, jeśli tutaj trafiłeś to pewnie z forum organizacji lub poprzez prywatną wiadomość.</p>
<p style="margin-left: 340px;">Strona ta ma na celu polepszenia kupowania, jak i sprzedawania pojazdów ale i nie tylko!
Dostępne aktualnie mamy aż 94 pojazdy z podstawowymi danymi z serwera, w tworzeniu tej strony wykorzystałem forum serwera w celu uzupełnienia informacji o pojazdach, a także tuningu. Strona jest darmowa i dostępna dla każdego, nie ma limitów co do ogłoszeń. Stronę zrobiłem bezinteresownie w celach nauki oraz fascynacji programowaniem i tworzeniem stron internetowych. Strona jest ciągle w budowie, wiec można spodziewać się wiele!</p>

<p style="margin-left: 340px;">Niemalże ciągle dodaje nowe dane lub poprawiam na aktualne, jeśli są osoby zainteresowane współpracą, w ulepszeniu strony zapraszam do skontaktowania się.</p>
<p style="clear: both;"></p>


<?php
}
echo '<div id="log_contener">';	


if($_GET['new']=='account'){


echo '<div id="log_content">';
echo '<h1>Witamy!</h1>';
echo '<form method="post" action="?regin=start&new=account">';
echo '</br>Nazwa w grze</br>';
echo '<input class="log_input" type="text" name="user_nick">';
echo '</br>Adres email</br>';
echo '<input class="log_input" type="text" name="user_email">';
echo '</br>Hasło</br>';
echo '<input class="log_input" type="password" name="user_pass">';
echo '</br><button class="button" style="vertical-align:middle"><span>Zarejestruj się </span></button>';
echo '</form>';
echo '</div>';

if($_GET['regin']=='start'){
	

function losowy_ciag($dlugosc){
  $string = md5(time());
  $string = substr($string,0,$dlugosc);
  return($string);
}
 
$ciag_znakow=losowy_ciag(25);

	

//odbieramy dane z post
$user_nick=$_POST['user_nick'];
$user_email=$_POST['user_email'];
$user_pass=$_POST['user_pass'];
//sprawdzamy czy mamy dane
$spr1=strlen($user_email);
$spr2=strlen($user_pass);
$spr3=strlen($user_nick);
if($spr1==0 OR $spr2==0 OR $spr3==0){
echo 'Musisz wypełnić wszystkie pola!';		
}else{
$user_emial2=strtolower($user_emial);	
$spr4=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_users WHERE LOWER(user_email)='".$user_emial2."'"));	
if($spr4['COUNT(*)']==0){
$user_nick2=strtolower($user_nick);	
$spr5=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_users WHERE LOWER(user_nick)='".$user_nick2."'"));	
if($spr5['COUNT(*)']==0){
$user_pass=md5($user_pass);	
mysql_query("INSERT INTO global_users SET user_nick='$user_nick', user_pid='$ciag_znakow', user_email='$user_email', user_pass='$user_pass', user_value='1', user_data=NOW(), user_ip='".$_SERVER['REMOTE_ADDR']."', user_perm='10'"); 

header("Location: /");// usunąc jesli przerwa	
}else{
echo '<div style="color: red;text-align: center;">Ten nick jest zajęty!</div>';		
}
}else{
echo '<div style="color: red;text-align: center;">Ten adres email jest zajęty!</div>';			
}
}
}

echo '</div>';
}



if($_GET['log']=='a'){
	
	echo '<h1>Zaloguj się</h1>';
	
	echo '<form method="post" action="/?log=start">';
	echo '<input type="text" placeholder="Adres email" class="log_input" style="width: 200px;" name="user_email">';
	echo '</br>';
	echo '<input type="password" placeholder="Hasło" class="log_input" name="user_pass">';
	echo '</br>';
	echo '<input type="submit" value="Zaloguj się" class="log_submit" style="margin-left: 0px;">';
	echo '</br>lub <a href="/?new=account">zarejestruj się</a>';
	echo '</form>';
	
	


}

if($_GET['log']=='start'){

//odbieramy dane z post
$user_email=$_POST['user_email'];
$user_pass=$_POST['user_pass'];
//sprawdzamy czy mamy dane
$spr1=strlen($user_email);
$spr2=strlen($user_pass);
if($spr1==0 OR $spr2==0){
echo 'Musisz wypełnić wszystkie pola!';	
}else{
$user_pass=md5($user_pass);	  
$spr3=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_users WHERE user_email='".$user_email."' AND user_pass='".$user_pass."'"));
if($spr3['COUNT(*)']>0){// tinymace!
$_session_1=mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_email='".$user_email."' AND user_pass='".$user_pass."'"));
if($_session_1['user_id']==1 OR $_session_1['user_id']==2){	
$_SESSION['user_id']=$_session_1['user_id'];
header("Location: /");
}else{
$ban=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_bans WHERE ban_user='".$_session_1['user_id']."' AND ban_value='1' AND ban_data_do>NOW()"));	
//echo 'Przerwa techniczna.';	
if($ban['COUNT(*)']==1){
$ban2=mysql_fetch_array(mysql_query("SELECT * FROM global_bans WHERE ban_user='".$_session_1['user_id']."' AND ban_value='1'"));
echo '<div style="color: red;text-align: center;">'.$ban2['ban_text'].' '.$ban2['ban_data_do'].'</div>';	
}else{
//echo '<div style="color: red;text-align: center;">Przerwa techniczna!</div>';		

$_SESSION['user_id']=$_session_1['user_id']; // usunąc jesli przerwa
header("Location: /");// usunąc jesli przerwa

}
}
}else{
echo '<div style="color: red;text-align: center;">Nie poprawny adres email lub hasło!</div>';	
}
}
}





?>
</div>




</div>
</div>

<?php include('in/footer.php'); ?>


</body>
</html>
















