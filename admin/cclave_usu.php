<?php session_start();
 header("Cache-control: no-cache");
 require_once('../conexion/conf.php');
 require_once ('../conexion/adodb.inc.php'); 
 include ('../conexion/dbm.php');
//conexión
$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

$ArchivoScripts = "../javascript/scripts.php";
include ($ArchivoScripts);

$fechaf1 = date("Y-m-d");	//date
$fechaf2 = date("Y-m-d H:i:s");	//datetime
$hora = date("H:i:s");	//time
$year = date("Y");	//año

$idsesion = $_SESSION["idsesion"];

$tipodato = $_POST['tipodato'];
$login = trim($_POST['login']);
$claveusuario = md5(trim($_POST['password1']));
$fecmod = $fechaf2;
$feccambio = $fechaf1;
$horcambio = $hora;
$feclimite = suma_fechas(date("d/m/Y"), 30);
$feclimite = cambiarFormatoFecha($feclimite);

?>

<html>
<head>
<title>Cambiar Contraseña del Usuario</title>

<LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_sistema.css"; ?>" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>

</head>
<body >
<br><br>

<?php
	$sql = "SELECT login FROM usuarios";
	$sql .= " WHERE login = '$login'";
	$result = $conexionMysql->db->Execute($sql);

if ($row_1 = $result->FetchNextObj())
{	//el login del usuario ya existe
	
		$sql  = "SELECT login, clave as clave FROM historico_claves";
		$sql .= " WHERE login = '$login'";
		$result = $conexionMysql->db->Execute($sql);
		
		while ($row_2 = $result->FetchNextObj())
		{
		
			if($row_2->clave == $claveusuario)
			{	//la calve ya se uso
				?>
				<script language="javascript">
					setTimeout("location.href='<?= $_SERVER['HTTP_REFERER']; ?>';",2000);
				</script>
					<table align="center" width="50%" border="3">
					<tr>
						<td align="center" class="titulo">
							<b>La clave ya fue utilizada</b>
						</td>
					</tr>
				</table>
				
				<?php 
				exit();
			}
		  }
			
			$sql = "UPDATE usuarios SET ";
			$sql = $sql . " clave = '$claveusuario'";
			$sql = $sql . " WHERE login = '$login'";
			$result = $conexionMysql->db->Execute($sql);
			

			$sql = "INSERT INTO historico_claves ";
			$sql = $sql . " (login, clave, consecutivo, feccambio, horcambio, feclimite)";
			$sql = $sql . " VALUES('$login', '$claveusuario', '$consecutivo', '$feccambio', '$horcambio', '$feclimite')";
			$result = $conexionMysql->db->Execute($sql);
			
			
			$sql = "SELECT max(consecutivo) as consec, count(login) as cant, min(consecutivo) as menor FROM historico_claves";
			$sql = $sql . " WHERE login = '$login'";
			$result = $conexionMysql->db->Execute($sql);
			
			$row_1 = $result->FetchNextObj();
						
			if ($row_1->cant == 20)
			{
				$sql = "DELETE FROM historico_claves";
				$sql = $sql . " WHERE login = '$login' and consecutivo = '$row_1->menor'";
				$result = $conexionMysql->db->Execute($sql);			
			}
	
	//CONTARLO COMO INGRESO
	$FechaIng = date("Y-m-d");
	$HoraIng = date("H:i:s");

	$sql = "UPDATE usuarios SET fecultingreso = '$FechaIng', horultingreso = '$HoraIng'";
	$sql = $sql . " WHERE login='$login' ";	
	//echo "<br>C1: ".$sql;
	$result_1 = $conexionMysql->db->Execute($sql);
			
	$sql = "SELECT * FROM historico_claves";
	$sql = $sql . " WHERE login = '$login' and consecutivo = '$consecutivo'";
	
	$result = $conexionMysql->db->Execute($sql);
	if ($row = $result->FetchNextObj())
	{	//SE INSERTO CORRECTAMENTE
		?>
		<script language="javascript">
			setTimeout("location.href='<?= $gloRutaPublica . "/admin/md_usuarios.php?ing=1"; ?>'",2000);
		</script>
		<table align="center" width="50%" border="3">
			<tr>
				<td align="center" class="titulo">
					<b>La clave se modific&oacute; satisfactoriamente</b>
				</td>
			</tr>
		</table>
		
		<?php
	}
	else
	{	?>
		<script language="javascript">
			setTimeout("location.href='<?= $_SERVER['HTTP_REFERER']; ?>';",2000);
		</script>
			<table align="center" width="50%" border="3">
			<tr>
				<td align="center" class="titulo">
					<b>Ha ocurrido un error actualizando los datos.</b>
				</td>
			</tr>
		</table>
		
		<?php
	}
	
}
else
{	
	?>
		<script language="javascript">
			setTimeout("location.href='<?= $_SERVER['HTTP_REFERER']; ?>';",2000);
		</script>
	<table align="center" width="50%" border="3">
		<tr>
			<td align="center" class="titulo">
				<b>- Ha ocurrido un error actualizando los datos.</b>
			</td>
		</tr>
	</table>
	
	<?php	
}	//fin del sino existe el usuario
?>
	
<?php
$conexionMysql->cerrar();
?>
</body>
</html>