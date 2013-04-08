<?php session_start();
header("Content-Type: text/html;charset=utf-8");
 require_once('conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 include ("conexion/Conect_DB.php"); 

//$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);
$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());
mysql_query("SET NAMES 'utf8'");
$identificador = $_POST['sociedad'];
$cliente_actual = $_POST['cliente'];
/*
$cliente_actual = 'C1015396791';
$identificador = '0010000105';
*/

$sql  = "SELECT DISTINCT numatcard, cardcode, id_integra FROM precios ";
$sql .= " Where id_integra = '$identificador' And cardcode = '$cliente_actual'";
$sql .= " Order by numatcard";
//echo $sql;
$result = mysql_query($sql,$link) or die(mysql_error());
$i = 0;
while($row = mysql_fetch_assoc($result))
{
	$numero_referencia[$i] = $row[numatcard];
	$i = $i + 1;
}

?>

<select name="numatcard" id="numatcard" style="width:250px;" onchange="TraerLineas(1);">
	<option></option>
		<?php 
			foreach ($numero_referencia as $key => $value) {
		?>
			<option value="<?= $value ?>" id="<? $value ?>"><?=  $value; ?></option>
		<?php
			}
	?>
</select>
</html>
