<?php session_start(); //error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);  
date_default_timezone_set('Europe/Warsaw');

$connection = @mysql_connect('mysql.ct8.pl', 'm6139_pyinfo', 'Nyt0yExDuUjBecDSCKMF') or die('Brak połączenia z serwerem MySQL. <br />Błąd: '.mysql_error());
$db = @mysql_select_db('m6139_pyinfo', $connection) or die('Nie mogę połączyć się z bazą danych<br />Błąd: '.mysql_error());
mysql_query("SET NAMES utf8mb4");

?>