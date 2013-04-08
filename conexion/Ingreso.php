<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ingreso = "localhost";
$database_ingreso = "sistema_pqr";
$username_ingreso = "root";
$password_ingreso = "misato28";//"Dvta*100pre";
$Ingreso = mysql_pconnect($hostname_ingreso, $username_ingreso, $password_ingreso) or trigger_error(mysql_error(),E_USER_ERROR); 
?>