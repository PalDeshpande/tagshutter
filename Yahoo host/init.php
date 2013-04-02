<?php
ob_start();
session_start();

mysql_connect('localhost','root','');//for localhost
//mysql_connect('mysql','rahul','123');//for yahoo
mysql_selectdb('mysql');

include 'function.php';
?>