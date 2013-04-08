<?php session_start();
 header("Cache-control: no-cache");
 require_once('../conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 include ("../conexion/Conect_DB.php"); 
 //conexión
$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

$ArchivoScripts = "../javascript/scripts.php";
include ($ArchivoScripts);

$login = $_GET['usu'];
$page = $_GET['page'];

?>

<SCRIPT type="text/javascript">
	   
	   function valida_campos() 
		{
			
			if (document.form.password1.value=='') 
			{
  				rc=alert('Ingrese el password');
  				document.form.password1.focus();
  				return false;
 			}
 			
			if (document.form.password2.value=='') 
			{
  				rc=alert('Ingrese la confirmación del password');
  				document.form.password2.focus();
  				return false;
 			}
			if (document.form.password1.value != document.form.password2.value) 
			{
  				rc=alert('Contraseña y confirmación no concuerdan');
  				document.form.password2.focus();
  				return false;
 			}
			
			if (document.getElementById("fortaleza").className < 4)
			{
				alert('El nivel de Fortaleza debe ser Mayor');
			
			return false;
			}
			
			if (document.form.login.value == '')
			{
				alert('Ingrese un Login');
				document.form.login.focus();
				return false;
			}
			
			if (confirm("Esta Seguro(a) de continuar?"))
				{
					$("#cargando_datos").html("<div align=left><font color=red face=arial size=3>&nbsp; &nbsp; Los datos están siendo cargados en la base, el tiempo de espera depender&aacute; de la cantidad de datos ingresados. ...</font></div>");
					return true;
				}
				else
				{
					return false;
				}
						
			
			return true;
		}
		
		function passwordStrength(password)
	{
		var desc = new Array();
		desc[0] = "Clave muy Débil";
		desc[1] = "Clave Débil";
		desc[2] = "Clave Bajo";
		desc[3] = "Clave Medio";
		desc[4] = "Clave Fuerte";
		desc[5] = "Clave Muy Fuerte";
	
		var score   = 0;
	
		//if password bigger than 6 give 1 point
		if (password.length > 6) score++;
	
		//if password has both lower and uppercase characters give 1 point	
		if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;
	
		//if password has at least one number give 1 point
		if (password.match(/\d+/)) score++;
	
		//if password has at least one special caracther give 1 point
		if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;
	
		//if password bigger than 10 give another 1 point
		if (password.length >= 10) score++;
	
		 document.getElementById("passwordDescription").innerHTML = desc[score];
		 document.getElementById("passwordDescription").className = "passwordText";
		 document.getElementById("passwordStrength").className = "strength" + score;
		 document.getElementById("fortaleza").className = score;
		// alert('Puntaje: '+score);
		 return score;
	}
		
		function carga ()
		{
			$("#password1").val();
			$("#password2").val();
		}
		

</script>

<html>
<head>
<title>Cambiar Clave</title>
<script language="javascript">
	
function reloj() {
// Obtiene la fecha actual
var fObj = new Date() ;
// Obtiene la hora
var horas = fObj.getHours() ;
// Obtiene los minutos
var minutos = fObj.getMinutes() ;
// Obtiene los segundos
var segundos = fObj.getSeconds() ;
// Si es menor o igual a 9 le concatena un 0
if (horas <= 9) horas = "0" + horas;
// Si es menor o igual a 9 le concatena un 0
if (minutos <= 9) minutos = "0" + minutos;
// Si es menor o igual a 9 le concatena un 0
if (segundos <= 9) segundos = "0" + segundos;
// Asigna la hora actual a la caja de texto reloj
document.form.reloj.value = horas+":"+minutos+":"+segundos;
}
// Cada segundo invoca la funcion reloj()
setInterval("reloj()",1000);
</script>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
window.addEvent('load', PageLoad);
function PageLoad()
{
	//new iToolkit.ComboEnlazado(hijo, padre, servicioDeDatos);
	//new iToolkit.ComboEnlazado("codcargo", "codarea", "services/GetCargosPorAreas.php");
//	new iToolkit.ComboEnlazado("cboProvincia", "cboPais", "services/GetProvinciasPorPais.php");
}
</script>
</script>

<LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_extranet.css"; ?>" type=text/css rel=stylesheet>
	<script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>
	<title><?php echo $gloNombrePublica . " " . $gloNombreCliente ?></title>
	<style>
	#passwordStrength {
		height:10px;
		display:block;
		float:left;
	}
	.passwordText {
		font-size:10px;
		font-family:Tahoma,Verdana,Arial;
	}

	.strength0 {
		width:150px;
		background:#cccccc;
	}
	.strength1 {
		width:30px;
		background:#ff0000;
	}
	.strength2 {
		width:60px;	
		background:#ff5f5f;
	}
	.strength3 {
		width:90px;
		background:#56e500;
	}
	.strength4 {
		background:#4dcd00;
		width:120px;
	}
	.strength5 {
		background:#399800;
		width:150px;
	}
	
	</style>

	
</head>
<body vlink="<?= $Color_Celda2; ?>" link="<?= $Color_Celda2; ?>" onLoad="carga();">
<br>

<?php

if (isset($login))
{	//SI NO SE HAN INGRESADO DATOS

$sql = "SELECT J0.* ";
$sql = $sql . " FROM usuarios AS J0 ";
$sql = $sql . " WHERE J0.login = '$login'";
$result = $conexionMysql->db->Execute($sql);
$row = $result->FetchNextObj();
?>
<form action="<?= "cclave_usu.php"; ?>" name="form" method="post" onSubmit="return valida_campos();">	
	<table border="3" align="center" width="70%" >	
		<tr>
			<td colspan="4" align="center" class="Tabla_Titulo">
				<b>Cambio de Clave</b>			
			</td>
		</tr>
					<input type="hidden" name="tipodato" value="1">
			
		<tr>
			<td width="40%" class="Tabla_Label">
				IdUsuario			</td>
			<td width="60%">
				<input type="text" name="idusuario" maxlength="15" value="<?= $row->idusuario; ?>" readonly>			</td>
		</tr>
		
		<tr>
			<td width="40%" class="Tabla_Label">
				Nombre de usuario			</td>
			<td width="60%">
				<input type="text" name="nombre" size="40" maxlength="60" value="<?= $row->nombre; ?>" readonly>			</td>
		</tr>
		
		<tr>
			<td width="40%" class="Tabla_Label">
			Login			</td>
			<td width="60%">
				<input type="text" name="login" maxlength="10" value="<?= $login; ?>" readonly>			</td>
		</tr>
		
		<tr>
				<td width="50%" class="Tabla_Label"><div align="left">Nueva Clave</div></td>
                <td width="50%" class="Tabla_Datos"><div align="left">
				<input name='password1' type='text' id="password1" size='20' maxlength='16' onKeyUp="passwordStrength(this.value)">
				    <input type="hidden" name="fortaleza" id="fortaleza">
                </div></td>
    	</tr>
		<tr>
				<td class="Tabla_Label">Fortaleza de Clave</td>
				<td>
				  	<div id="passwordDescription"><font size="1" style="font-family:Arial, Helvetica, sans-serif">Clave no ingresada</font></div> 
					<div id="fortaleza"></div>
					<div id="passwordStrength" class="strength0"></div>
				</td>
		</tr>
		<tr>
			<td width="45%" class="Tabla_Label"><div align="left">Confirmar Clave</div></td>
            <td width="55%" class="Tabla_Datos"><div align="left"><input name='password2' type='password' id="password2" size='20' maxlength='16' >
   	        </div></td>
        </tr>
		
		
		<tr>
			<td colspan="2" >
			<div align="center">            					
				<input type="hidden" name="page" value="<?= $page; ?>" />
				<input name="submitButton" type="submit" class="Boton_Submit" id="submitButton" style="Width: 80px;" value="Aceptar" >
				<input type="reset" value= "Limpiar" style="Width: 80px;" class="Boton_Submit" >
			</div></td>
		</tr>
	</table>
</form>	
<table border="0" align="center">
	<tr>
		<td align="center" onClick="javascript:location.href='<?= $page; ?>';" >
			<img src="<? echo $gloRutaPublica . "/imagenes/volver.png"; ?>" width="40" height="50" alt="Volver" style="cursor:pointer">
		</td>
	</tr>
</table>	
<?php 
include "extranet_pie.php";  ?>

<?php
$sql = "";
$sql = $sql . "";
$result = $conexionMysql->db->Execute($sql);
}	//FIN DEL IF PARA EL TIPO DE DATO NUEVO

else
{	//
?>
	<script language="javascript">
		alert("sino " + <?= $codmodulo; ?>);
	</script>
<?php 
}	// FIN DEL SINO 
?>
<br>
<!--table border="0" align="center" >
	<tr>
		<td align="center" onClick="javascript:location.href='javascript:history.back()';" >
		<img src="<? echo $gloRutaPublica . "/imagenes/volver.gif"; ?>" width="40" height="50" alt="Volver" style="cursor:pointer">
		</td>
	</tr>
</table-->	

<?php
$conexionMysql->cerrar();
?>
</body>
</html>