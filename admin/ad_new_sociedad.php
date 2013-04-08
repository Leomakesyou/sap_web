<?php session_start();
 header("Cache-control: no-cache");
 require_once('../conexion/conf.php');
 require_once ('../conexion/adodb.inc.php'); 
 include ('../conexion/dbm.php');
 
$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

$tipodato = $_GET['tipodato'];
$idsoc = $_GET['cia'];

?>

<SCRIPT type="text/javascript">
	   
	   function valida_campos() 
		{
			
			if (document.form.cmpname.value == '')
			{
				alert("Debe Ingreser un nombre de la sociedad");
				document.form.cmpname.focus();
				return false;
			}
			if (document.form.id_integra.value == '')
			{
				alert("Debe Ingreser Id de Integración");
				document.form.id_integra.focus();
				return false;
			}
			
			if (confirm("Esta Seguro(a)?"))
			{
				return true;
			}
			else
			{
				return false;
			}
			
			return true;
		}
	
</script>

<html>
<head>
<title>Nueva Sociedad del Sistema</title>
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

	<LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_admin.css"; ?>" type=text/css rel=stylesheet>
	<script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>
	<title><?php echo $gloNombrePublica . " " . $gloNombreCliente ?></title>
	
</head>
<body vlink="<?= $Color_Celda2; ?>" link="<?= $Color_Celda2; ?>" onLoad="carga();">
<br><br>

<?php

if ($tipodato == 1)
{	//Nuevo Dato
?>
<form action="<?= "new_sociedad.php"; ?>" name="form" method="post" onSubmit="return valida_campos();">	
	<table border="3" align="center" width="50%" >	
		<tr>
			<td colspan="4" align="center" class= "tabla_s1_td_t1" >
				<b>Sociedades</b>			
			</td>
		</tr>
		<tr>
			<td width="40%" class="Tabla_Label">
				id Sociedad			</td>
			<td width="60%" class="tabla_s1_td_c1">
				Autogenerado	
			</td>
		</tr>
		
		<tr>
			<td width="40%" class="Tabla_Label">
				Nombre de la Sociedad			
			</td>
			<td width="60%" >
				<input type="text" name="cmpname" maxlength="100" size="60">
			</td>
		</tr>
		<tr>
			<td width="40%" class="Tabla_Label">
				Id Integra			
			</td>
			<td width="60%" >
				<input type="text" name="id_integra" maxlength="10" size="20">
			</td>
		</tr>
		
		<tr>
			<td colspan="2" class="Tabla_Datos"><div align="center"></div>
			<input type="hidden" name="tipodato" value="<?= $tipodato ?>">
			<div align="center">            					
<input name="submitButton" type="submit" class="Boton_Submit" id="submitButton" style="Width: 80px;" value="Crear" onMouseOver="javascript:mOvr(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOVER,'','');" onMouseOut="javascript:mOut(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOUT,'','');" >
			<input type="reset" value= "Limpiar" style="Width: 80px;" class="Boton_Submit" onMouseOver="javascript:mOvr(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOVER,'','');" onMouseOut="javascript:mOut(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOUT,'','');">
			  </div></td>
		</tr>
	</table>
</form>	



<?php

}	//FIN DEL IF PARA EL TIPO DE DATO NUEVO

else
{	// SI TIPO DE DATO ES DIFERENTE A 1 Modificar Dato

$sql  = "SELECT * FROM srgc";
$sql .= " WHERE idsoc = '$idsoc'";
$result = $conexionMysql->db->Execute($sql);
$row = $result->FetchNextObj();
?>

<form action="<?= "new_sociedad.php"; ?>" name="form" method="post" onSubmit="return valida_campos();">	
	<table border="3" align="center" width="50%" >	
		<tr>
			<td colspan="4" align="center" class= "tabla_s1_td_t1" >
				<b>Sociedades</b>			
			</td>
		</tr>
				
		<tr>
			<td width="40%" class="Tabla_Label">
				Id Sociedad			
			</td>
			<td width="60%">
				<input type="text" name="idsoc" value="<?= $row->idsoc; ?>" readonly>			
			</td>
		</tr>
		
		<tr>
			<td width="40%" class="Tabla_Label">
				Nombre sociedad			
			</td>
			<td width="60%">
				<input type="text" name="cmpname" size="60" maxlength="100" value="<?= $row->cmpname; ?>">			
			</td>
		</tr>
		<tr>
			<td width="40%" class="Tabla_Label">
				Id Integra			
			</td>
			<td width="60%" >
				<input type="text" name="id_integra" maxlength="10" size="20" value="<?= $row->id_integra; ?>">
			</td>
		</tr>
		<tr>
			<td width="40%" class="Tabla_Label">
				Estado			
			</td>
			<td width="60%">
				<select name="activo">
					<option value="Y">Activo</option>
					<option value="N">Inactivo</option>
				</select>
		</tr>
				
		<tr>
			<td colspan="2" class="Tabla_Datos"><div align="center"></div>
			<input type="hidden" name="tipodato" value="<?= $tipodato ?>">
			 <div align="center">            					
<input name="submitButton" type="submit" class="Boton_Submit" id="submitButton" style="Width: 80px;" value="Actualizar" onMouseOver="javascript:mOvr(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOVER,'','');" onMouseOut="javascript:mOut(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOUT,'','');" tabindex="3">
<input type="reset" value= "Limpiar" style="Width: 80px;" class="Boton_Submit" onMouseOver="javascript:mOvr(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOVER,'','');" onMouseOut="javascript:mOut(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOUT,'','');">
			  </div>
			 </td>
		</tr>
	</table>
</form>	

<?php
}	// FIN DEL SINO 
?>
<br>
<table border="0" align="center" width="20%">
	<tr>
		<td align="center" onClick="javascript:location.href='md_sociedades.php';" ><img src="<? echo $gloRutaPublica . "/imagenes/volver.gif"; ?>" width="40" height="50" alt="Volver" style="cursor:pointer">
		</td>
	</tr>
</table>	

<?php
$conexionMysql->cerrar();
?>
</body>
</html>