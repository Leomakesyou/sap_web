<?php session_start();
 header("Cache-control: no-cache");
/*
 require_once('conexion/conf.php');
 require_once ('conexion/adodb.inc.php'); 
 include ('conexion/dbm.php');
 */
 include $_SERVER[DOCUMENT_ROOT] . "/consultas/includes/conf.php"; 
 include $gloInclude . "/parametros.php";  
 include $gloAdodb . "/adodb.inc.php"; 
 include $clase_BD; 
 require ($gloIncludeAplicacion . "/extranet_chklogin.php");
 require_once("clases/excel.php"); 
 require_once("clases/excel-ext.php");
//conexión

$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);
$conexionIseries = new ConectarIseries($gloDbDriverIseries, $gloDbDsnIseries, $gloDbUserIseries, $gloDbPasswordIseries);

$qry = $_POST['consulta'];
$nombre_excel = $_POST['nombre_excel'];
//echo "<br>Archivo: ".$nombre_excel;
if (!isset($qry) and !isset($nombre_excel))
{
	$qry = $_GET['qry'];
	$nombre_excel = $_GET['nombre_excel'];
}

$conexionIseries->db->setFetchMode(ADODB_FETCH_ASSOC);
$resultset = $conexionIseries->db->Execute($qry);

$rows = $conexionIseries->db->Execute($qry);
$column = array();
foreach($rows as $row) {
    	$column[] = $row;
}
if (isset($nombre_excel))
{ createExcel($nombre_excel, $column); }

exit;
?>