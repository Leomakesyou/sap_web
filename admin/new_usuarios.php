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

$idusuario = $_POST['idusuario'];
$nombre = $_POST['nombre'];
$login = $_POST['login'];
$clave = md5(trim($_POST['password1']));
$idperfil = $_POST['idperfil'];
$price_list = $_POST['price_list'];
$activo = $_POST['activo'];
$email = $_POST['email'];
$admin = $_POST['admin'];
$campoextra1 = $_POST['campoextra1'];

$fecmod = $fechaf2;

?>
<html>
<head>
<title>Nuevo Usuario del Sistema</title>
<LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_admin.css"; ?>" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>

</head>
<body>
<br>

<?php

//echo "<br>Tipo dato: ".$tipodato;
	
if ($tipodato == '2')
{	//Actualziar la Datos

	$sql = "UPDATE usuarios  SET ";
	$sql .= " nombre = '$nombre', idperfil = '$idperfil', email = '$email', admin = '$admin', price_list = '$price_list', activo = '$activo', fecmod = '$fecmod'";
	$sql .= " where idusuario = '$idusuario'";
	//echo "<br>SQL: ".$sql;
	$result = $conexionMysql->db->Execute($sql);
	
	?>
	<script language="javascript">
			 setTimeout("location.href='md_usuarios.php';",2000);
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
{	//Crear Datos 

	$sql  = "SELECT login FROM usuarios";
	$sql .= " WHERE login = '$login'";
	$result = $conexionMysql->db->Execute($sql);
	
	if ($row = $result->FetchNextObj())
	{ ?>
		<script language="javascript">
			 setTimeout("javascript:location.href='javascript:history.back()';",2000);
		</script>
			<table align="center" width="50%" border="3">
			<tr>
				<td align="center" class= "tabla_s1_td_t1">
					<font size="+1"><b>El Login Ya esta siendo Utilizado</b></font>
				</td>
			</tr>
		</table>
		
		<?php
	}
	else
	{
		if (!isset($login) or trim($login) != '')
		{	
			$activo = "Y";
			$sql = "INSERT INTO usuarios ";
			$sql .= " (nombre, login, clave, idperfil, activo, email, admin,price_list, fecmod, feccreacion)";
			$sql .= " VALUES('$nombre', '$login', '$clave', '$idperfil', '$activo', '$email', '$admin','$price_list', '$fecmod', '$feccreacion')";
			//echo "<br>SQL: ".$sql;
			$result = $conexionMysql->db->Execute($sql);

			foreach($sociedad as $key => $value){
				$sql = "INSERT INTO companiasxusuarios ";
				$sql .= " (idcia, login, fecmod)";
				$sql .= " VALUES('$sociedad[$key]', '$login', '$fecmod')";
				//echo "<br>SQL: ".$sql;
				$result = $conexionMysql->db->Execute($sql);
			}
		}
		
		$sql  = "SELECT login FROM usuarios";
		$sql .= " WHERE login = '$login'";
		$result = $conexionMysql->db->Execute($sql);
		
		if ($row = $result->FetchNextObj())
		{	//SE INSERTO CORRECTAMENTE
			?>
			<script language="javascript">
				 setTimeout("location.href='<?= "md_usuarios.php";?>';",2000);
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
				 setTimeout("location.href='<?= "md_usuarios.php";?>';",2000);
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
	}
	
}	//fin del sino
?>
	

<?php
$conexionMysql->cerrar();
?>
</body>
</html>