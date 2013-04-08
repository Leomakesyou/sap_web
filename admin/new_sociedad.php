<?php session_start();
 header("Cache-control: no-cache");
 require_once('../conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD; 

 $conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

$fechaf1 = date("Y-m-d");	//date
$fechaf2 = date("Y-m-d H:i:s");	//datetime
$hora = date("H:i:s");	//time
$year = date("Y");	//año

$tipodato = $_POST['tipodato'];

$idsoc = $_POST['idsoc'];
$cmpname = $_POST['cmpname'];
$identificador = $_POST['cmpname'];
$id_integra = $_POST['id_integra'];
$activo = $_POST['activo'];
$fecmod = $fechaf2;

?>

<html>
<head>
<title>Nueva Sociedad del Sistema</title>
<LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_admin.css"; ?>" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>

</head>
<body>
<br>

<?php

//echo "<br>Tipo dato: ".$tipodato;
	
if ($tipodato == '2')
{	//Actualziar la Sociedad

	$sql = "UPDATE srgc SET ";
	$sql .= " cmpname = '$cmpname', identificador = '$identificador', id_integra = '$id_integra', activo = '$activo', fecmod = '$fecmod'";
	$sql .= " where idsoc = '$idsoc'";
	//echo "<br>SQL: ".$sql;
	$result = $conexionMysql->db->Execute($sql);
	
	?>
	<script language="javascript">
			setTimeout("location.href='md_sociedades.php';",2000);
		</script>
	<table align="center" width="50%" border="3">
		<tr>
			<td align="center" class= "tabla_s1_td_t1">
				<font size="+2"><b>Datos Actualizados</b></font>
			</td>
		</tr>
	</table>
	
	<?php 
}
if ($tipodato == '1')
{	//crear la sociedad 

	if (!isset($idsoc) or trim($idsoc) != '')
	{	
		$activo = "Y";
		$sql = "INSERT INTO srgc";
		$sql .= " (cmpname, identificador, id_integra, activo, fecmod)";
		$sql .= " VALUES('$cmpname', '$identificador', '$id_integra', '$activo', '$fecmod')";
		//echo "<br>SQL: ".$sql;
		$result = $conexionMysql->db->Execute($sql);
	}
	
	$sql  = "SELECT * FROM srgc";
	$sql .= " WHERE idsoc = (Select max(idsoc) from srgc)";
	$result = $conexionMysql->db->Execute($sql);
	$row = $result->FetchNextObj();
	if ($row->cmpname == $cmpname)
	{	//SE INSERTO CORRECTAMENTE
		?>
		<script language="javascript">
			setTimeout("location.href='<?= "md_sociedades.php";?>';",2000);
		</script>
		<table align="center" width="50%" border="3">
			<tr>
				<td align="center" class= "tabla_s1_td_t1">
					<font size="+1"><b>Datos creados</b></font>
				</td>
			</tr>
		</table>
		
		<?php
	}
	else
	{	?>
		<script language="javascript">
			setTimeout("location.href='<?= "md_sociedades.php";?>';",2000);
		</script>
			<table align="center" width="50%" border="3">
			<tr>
				<td align="center" class= "tabla_s1_td_t1">
					<font size="+1"><b>Los datos no se registraron correctamente</b></font>
				</td>
			</tr>
		</table>
		
		<?php
	}
}	//fin del sino existe el usuario
?>
	

<?php
$conexionMysql->cerrar();
?>
</body>
</html>


