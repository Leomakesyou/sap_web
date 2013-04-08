<?php session_start();
 header("Cache-control: no-cache");
 require_once('../conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD; 
//conexión
$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

$ArchivoScripts = "../javascript/scripts.php";
include ($ArchivoScripts);

$fechaf1 = date("Y-m-d");	//date
$fechaf2 = date("Y-m-d H:i:s");	//datetime
$hora = date("H:i:s");	//time
$year = date("Y");	//año

$tipodato = $_POST['tipodato'];
$perfil = $_POST['perfil'];
$desperfil = $_POST['desperfil'];
$obsperfil = $_POST['obsperfil'];
$fecmod = $fechaf2;


$aplicacion = $_POST['aplicacion'];
$modulo = $_POST['modulo'];

foreach($_POST[sociedad] as $key => $value){
	$sociedad[$key]	= $_POST[sociedad][$key];
}

?>

<html>
<head>
<title>Nuevo Perfil de Usuario del Sistema</title>
<LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_admin.css"; ?>" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>

<script language="JavaScript" type="text/javascript">
window.addEvent('load', PageLoad);
function PageLoad()
{
	alert("Entro 1");
	alert("Entro 2");
}
</script>

</head>
<body >
<br><br>
<?php

	
if ($tipodato == '2')
{	//el perfil ya existe se debe Modificar

	$sql = "UPDATE perfiles set desperfil = '$desperfil', obsperfil = '$obsperfil', fecmod = '$fecmod'";
	$sql = $sql . " WHERE idperfil = '$perfil'";
	//echo "<br>SQL1: ".$sql;
	$result = $conexionMysql->db->Execute($sql);
	
	$sql  = "Delete From companiasxperfiles";
	$sql .= " Where idperfil = '$perfil'";
	$result = $conexionMysql->db->Execute($sql);

		foreach($sociedad as $key => $value){
			$sql = "INSERT INTO companiasxperfiles ";
			$sql .= " (idcia, idperfil, fecmod)";
			$sql .= " VALUES('$sociedad[$key]', '$perfil', '$fecmod')";
			//echo "<br>SQL: ".$sql;
			$result = $conexionMysql->db->Execute($sql);
		}


	$sql = "DELETE FROM menu_aplicacionesxperfil";
	$sql = $sql . " WHERE idperfil = '$perfil'";
	//echo "<br>SQL1: ".$sql;
	$result = $conexionMysql->db->Execute($sql);
	
	
	if (is_array($_POST['aplicacion']))
	{ 
		foreach ($_POST['aplicacion'] as $valor) {
			
			$sql = "INSERT INTO menu_aplicacionesxperfil";
			$sql .= " (idaplicacion, idperfil, fecmod)";
			$sql .= " VALUES('$valor', '$perfil', '$fecmod')";
			$result = $conexionMysql->db->Execute($sql);
		    //echo "Apli : ".$sql.'<br>';
		//  echo "seleccion es:".implode(',',$aplicacion)."<br>\n";
		} 
	}
	
	?>
	<script language="javascript">
			setTimeout("location.href='md_perfiles.php';",2000);
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($tipodato == '1')
{	//El perfil no existe y se debe Crear
	
	$sql = "Select max(idperfil) + 1 as perfil From perfiles";
	//echo "<br>SQL: ".$sql;
	$result = $conexionMysql->db->Execute($sql);
	$row_2 = $result->FetchNextObj();
	$perfil = $row_2->perfil;
	$sql = "INSERT INTO perfiles";
	$sql = $sql . " (desperfil, obsperfil, fecmod)";
	$sql .= " VALUES('$desperfil', '$obsperfil', '$fecmod')";
	//echo "<br>SQL: ".$sql;
	$result = $conexionMysql->db->Execute($sql);
	
	$sql  = "Delete From companiasxperfiles";
	$sql .= " Where idperfil = '$perfil'";
	$result = $conexionMysql->db->Execute($sql);
	
		foreach($sociedad as $key => $value){
			$sql = "INSERT INTO companiasxperfiles ";
			$sql .= " (idcia, idperfil, fecmod)";
			$sql .= " VALUES('$sociedad[$key]', '$perfil', '$fecmod')";
			//echo "<br>SQL: ".$sql;
			$result = $conexionMysql->db->Execute($sql);
		}

	///// LAS APLICACIONES 
	
	$sql = "DELETE FROM menu_aplicacionesxperfil";
	$sql = $sql . " WHERE idperfil = '$perfil'";
	//echo "<br>SQL: ".$sql;
	$result = $conexionMysql->db->Execute($sql);
	
	if (is_array($_POST['aplicacion']))
	{ 
		foreach ($_POST['aplicacion'] as $valor) {
			
					
			$sql = "INSERT INTO menu_aplicacionesxperfil";
			$sql .= " (idaplicacion, idperfil, fecmod)";
			$sql .= " VALUES('$valor', '$perfil', '$fecmod')";
			$result = $conexionMysql->db->Execute($sql);
		//    echo "Apli : ".$sql.'<br>';
		//  echo "seleccion es:".implode(',',$aplicacion)."<br>\n";
		} 
	}
	
	$sql = "SELECT * FROM perfiles";
	$sql = $sql . " WHERE idperfil = '$perfil'";
	$result = $conexionMysql->db->Execute($sql);
	if ($row = $result->FetchNextObj())
	{	//SE INSERTO CORRECTAMENTE
		?>
		<script language="javascript">
			setTimeout("location.href='<?= "md_perfiles.php";?>';",2000);
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
			setTimeout("location.href='<?= "md_perfiles.php";?>';",2000);
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