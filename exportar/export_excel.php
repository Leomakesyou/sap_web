<?php session_start();
 header("Cache-control: private");
 /*require_once('../conexion/conf.php');
 require_once ('../conexion/adodb.inc.php'); 
 include ('conexion/dbm.php');*/

 include $_SERVER[DOCUMENT_ROOT] . "/consultas/includes/conf.php"; 
 include $gloInclude . "/parametros.php";  
 include $gloAdodb . "/adodb.inc.php"; 
 include $clase_BD; 
 require ($gloIncludeAplicacion . "/extranet_chklogin.php");
 

 require_once("clases/excel.php"); 
 require_once("clases/excel-ext.php");
 //conexión

$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

$qry = $_POST['consulta'];
$nombre_excel = $_POST['nombre_excel'];
//echo "<br>Archivo: ".$nombre_excel;
if (!isset($qry) and !isset($nombre_excel))
{
	$qry = $_GET['qry'];
	$nombre_excel = $_GET['nombre_excel'];
}
echo "<br/>qry: ".$qry."<br/>";
//$qry = DesencriptarDato($qry);
$caracteres = array("\'");
$qry = str_replace($caracteres, "'",$qry);
$cnn = mysql_connect($gloDbHost, $gloDbUser, $gloDbPassword) or die(mysql_error());
mysql_select_db($gloDb, $cnn) or die(mysql_error());
$sql =  $qry; //"SELECT nombre, direccion, telefono FROM empresa";
$result = mysql_query($sql, $cnn) or die(mysql_error());
//$totEmp = mysql_num_rows($resEmp);
// Creamos el array con los datos
while($datatmp = mysql_fetch_assoc($result)) {
    $data[] = $datatmp;
	//echo "<br>".$data;
}

if (isset($nombre_excel))
{
createExcel($nombre_excel, $data);
}
//createExcel("excel-array.xls", $assoc);
exit;