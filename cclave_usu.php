<?php session_start();
 header("Cache-control: no-cache");
 require_once('conexion/conf.php');
 require_once ('conexion/adodb.inc.php'); 
 include ('conexion/dbm.php');
 //Para los enlaces de combobox/////////////////
 include("includes/funciones.inc.php");
 include("includes/claseRecordset.inc.php"); 
 include("includes/conexion.inc.php");
//echo "entro 1<br>";
//conexión
$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

$ArchivoScripts = "javascript/scripts.php";
include ($ArchivoScripts);

$fechaf1 = date("Y-m-d");	//date
$fechaf2 = date("Y-m-d H:i:s");	//datetime
$hora = date("H:i:s");	//time
$year = date("Y");	//año

$idsesion = $_SESSION['idsesion'];

$tipodato = $_POST['tipodato'];
$login = trim($_POST['login']);
$claveusuario = md5(trim($_POST['password1']));

$fecmod = $fechaf2;
$feccambio = $fechaf1;
$horcambio = $hora;
$feclimite = suma_fechas(date("d/m/Y"), 60);
//echo "entro 2-<br>";
$feclimite = cambiarFormatoFecha($feclimite);
$page = $_POST[page];

if ($page == '')
{
	$page = $_SERVER['HTTP_REFERER'];
}

?>

<html>
<head>
<title>Cambiar Contraseña del Usuario</title>
<!--LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_sistemas.css"; ?>" type=text/css rel=stylesheet-->
<script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>
	<style type="text/css">
		.titulo{
			background-color:#104070;
			font: bold 12pt Verdana, Arial, Helvetica, sans-serif;
			color:#FFFFFF;
			height: 25px;
		}
	</style>
</head>
<body vlink="<?= $Color_Celda2; ?>" link="<?= $Color_Celda2; ?>" onLoad="carga();">
<br><br>

<?php
	$sql = "SELECT login FROM usuarios";
	$sql = $sql . " WHERE login = '$login'";
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
					setTimeout("location.href='<?= $page; ?>';",2000);
				</script>
					<table align="center" width="60%" border="3">
					<tr>
						<td align="center" class="titulo">
							<b>La clave no es valida - ya se ha utilizado anteriormente.  </b>
						</td>
					</tr>
				</table>
				
				<?php 
				exit();
			}
		  }
			
			$sql = "UPDATE usuarios SET ";
			$sql = $sql . " clave = '$claveusuario', feccambio = '$feccambio', feclimite = '$feclimite'";
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
			setTimeout("location.href='<?= $page; ?>'",2000);
		</script>
		<table align="center" width="60%" border="3">
			<tr>
				<td align="center" class="titulo">
					<b>La Clave se ha modificado</b>
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
			<table align="center" width="60%" border="3">
			<tr>
				<td align="center" class="titulo">
					<b>Se ha presentado un error y no fue posible continuar el proceso.</b>
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
	<table align="center" width="60%" border="3">
		<tr>
			<td align="center" class="titulo">
				<b>Se ha presentado un error y no fue posible</b>
			</td>
		</tr>
	</table>
	
	<?php	
}	//fin del sino existe el usuario
?>

<?php 
include "extranet_pie.php";  ?>
	
<?php
$conexionMysql->cerrar();
?>
</body>
</html>