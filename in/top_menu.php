<?php
$var1 = $_SERVER['REQUEST_URI'];
$var2 = $_SERVER['SERVER_NAME'];
$vart1 = 'https://'.$var2.$var1;
$vart2 = $var2.$var1;

$adres = 'www.pyinfo.tk';
if($var2==$adres){}else{Header("Location: https://www.pyinfo.tk".$var1);}






echo '<div id="top_menu_bar">';
if($_SESSION['user_id']){
$__sellect = mysql_fetch_array(mysql_query("SELECT * FROM global_users WHERE user_id='".$_SESSION['user_id']."'"));  
if($__sellect['user_perm']>89){
$__p = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_post WHERE post_value='0'"));  
echo '<div class="admin_"><a href="/waiting/">Oczekuje postów</a>: '.$__p['COUNT(*)'].'</div>';
echo '<div class="admin_2"><a href="/mod-room/" style="color: red;">MODroom</a></div>';
}
}
if($_SESSION['user_id']){
   echo '<div id="top_menu_center">';
   echo '<a href="/" title="FunnyWoT jest to strona poświęcona gromadzeniu śmiesznych obrazków o tematyce World of Tanks lub związanej z czołgami."><div style="background: url(\'https://www.funnywot.tk/images/logo/11.gif\');" class="_ul_list"><img height="34px" src="/images/logo.png"></div></a>';
if($adres.'/' == $vart2){echo '<a href="/"><div class="list_top_menu active">Główna</div></a>';}else{echo '<a href="/"><div class="list_top_menu">Główna</div></a>';}   
if($adres.'/new/?page='.$_GET['page'] == $vart2){echo '<a href="/new/?page=0"><div class="list_top_menu active">Nowe</div></a>';}else{echo '<a href="/new/?page=0"><div class="list_top_menu">Nowe</div></a>';} 
if($adres.'/cars_info/' == $vart2 OR $adres.'/cars_info/?search='.$_GET['search'] == $vart2){echo '<a href="/cars_info/"><div class="list_top_menu active">Cars Info</div></a>';}else{echo '<a href="/cars_info/"><div class="list_top_menu">Cars Info</div></a>';} 

if($adres.'/tune_info/' == $vart2){echo '<a href="/tune_info/"><div class="list_top_menu active">Tune info</div></a>';}else{echo '<a href="/tune_info/"><div class="list_top_menu">Tune info</div></a>';}  

		  
if($adres.'/profil/?user='.$_SESSION['user_id'].'' == $vart2 OR $adres.'/profil/?user='.$_SESSION['user_id'].'&page='.$_GET['page'] == $vart2){echo '<a href="/profil/?user='.$_SESSION['user_id'].'"><div class="list_top_menu active">'.$__sellect['user_nick'].'</div></a>';}else{echo '<a href="/profil/?user='.$_SESSION['user_id'].'"><div class="list_top_menu">'.$__sellect['user_nick'].'</div></a>';}

$__q = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM global_pow WHERE pow_user_id='".$_SESSION['user_id']."' AND pow_ck='0'"));  
if($adres.'/notifi/' == $vart2){echo '<a title="Kliknij aby zobaczyć powiadomienia." href="/notifi/"><div class="list_top_menu_special active"><div class="pow_count_">'.$__q['COUNT(*)'].'</div><i class="fa fa-bell-o" aria-hidden="true"></i></div></a>';}else{echo '<a href="/notifi/" title="Kliknij aby zobaczyć powiadomienia."><div class="list_top_menu_special"><div class="pow_count">'.$__q['COUNT(*)'].'</div><i class="fa fa-bell" aria-hidden="true"></i></div></a>';}  
if($adres.'/add/' == $vart2){echo '<a title="Kliknij aby dodać nowy obrazek lub gif." href="/add/"><div class="list_top_menu_special active"><i class="fa fa-plus" aria-hidden="true"></i></div></a>';}else{echo '<a href="/add/" title="Kliknij aby dodać nowy obrazek lub gif."><div class="list_top_menu_special"><i class="fa fa-plus" aria-hidden="true"></i></div></a>';}    
      echo '<a href="/?log=out"><div class="list_top_menu_special" title="Kliknij aby wylowgować się."><i class="fa fa-sign-out" aria-hidden="true"></i></div></a>';


	  echo '<div class="__clear-both"></div>';
   echo '</div>';
   echo '<div style="background: url(\'/images/orange1.png\');background-position: bottom;padding: 1px;"></div>';
echo '</div>';
}else{
   echo '<div id="top_menu_center_2">';
   echo '<a href="/" title="FunnyWoT jest to strona poświęcona gromadzeniu śmiesznych obrazków o tematyce World of Tanks lub związanej z czołgami."><div style="background: url(\'https://www.funnywot.tk/images/logo/11.gif\');" class="_ul_list"><img height="34px" src="/images/logo.png"></div></a>';
if($adres.'/' == $vart2){echo '<a href="/"><div class="list_top_menu active">Główna</div></a>';}else{echo '<a href="/"><div class="list_top_menu">Główna</div></a>';}   
if($adres.'/new/?page='.$_GET['page'] == $vart2){echo '<a href="/new/?page=0"><div class="list_top_menu active">Nowe</div></a>';}else{echo '<a href="/new/?page=0"><div class="list_top_menu">Nowe</div></a>';} 
if($adres.'/cars_info/' == $vart2 OR $adres.'/cars_info/?search='.$_GET['search'] == $vart2){echo '<a href="/cars_info/"><div class="list_top_menu active">Cars Info</div></a>';}else{echo '<a href="/cars_info/"><div class="list_top_menu">Cars Info</div></a>';} 
 	  
if($adres.'/tune_info/' == $vart2){echo '<a href="/tune_info/"><div class="list_top_menu active">Tune info</div></a>';}else{echo '<a href="/tune_info/"><div class="list_top_menu">Tune info</div></a>';}    

echo '<a href="/?log=a"><div title="Kliknij aby zalogować się na stronie." class="list_top_menu">Zaloguj się</div></a>'; 

	  echo '<div class="__clear-both"></div>';
   echo '</div>';
   echo '<div style="background: url(\'/images/orange1.png\');background-position: bottom;padding: 1px;"></div>';
echo '</div>';		  
}

    if($_GET['wg'] == 'logout'){
	session_destroy();
	header("Location: /?s=dlog");
	}	
?>