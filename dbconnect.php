<?php 
$host = "localhost";
$user = "root";
$pass = "ntkacml1";
$dbname = "";
$conn=  mysql_connect($host,$user,$pass) or die("ไม่สามารถเชื่อมต่อฐานข้อมูลได้");
mysql_select_db($dbname,$conn);
mysql_query("SET NAMES utf8");
?>
