<?php session_start();
 header("Cache-control: no-cache");
 require_once('../conexion/conf.php');
 require_once ('../conexion/adodb.inc.php'); 
 include ('../conexion/dbm.php');
 
$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

$tipodato = $_GET['tipodato'];
$idusuario = $_GET['usu'];

?>

<SCRIPT type="text/javascript">
	   
	   function valida_campos() 
		{
			
			if (document.form.nombre.value == '')
			{
				alert("Debe Ingreser un nombre de Usuario");
				document.form.nombre.focus();
				return false;
			}

			if (document.form.login.value == '')
			{
				alert('Ingrese un Login');
				document.form.login.focus();
				return false;
			}
			if (document.form.login.value == '')
			{
				alert('Ingrese una Lista de Precio');
				document.form.price_list.focus();
				return false;
			}
			if (document.form.idperfil.value == '')
			{
				alert('Seleccione un Perfil');
				document.form.idperfil.focus();
				return false;
			}
			if (document.form.password1.value=='') 
			{
  				rc=alert('Ingrese el password');
  				document.form.password1.focus();
  				return false;
 			}
 			if (document.form.password2.value=='') 
			{
  				rc=alert('Ingrese la confirmacion del password');
  				document.form.password2.focus();
  				return false;
 			}
			if (document.form.password1.value != document.form.password2.value) 
			{
  				rc=alert('Contraseña y confirmacion no concuerdan');
  				document.form.password2.focus();
  				return false;
 			}
 			if (document.form.fortaleza.value < 4)
			{
				alert('El nivel de Fortaleza debe ser Mayor '+document.form.fortaleza.value);
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
	
	function passwordStrength(password)
	{
		var desc = new Array();
		desc[0] = "Clave muy Debil";
		desc[1] = "Clave Debil";
		desc[2] = "Clave Bajo";
		desc[3] = "Clave Medio";
		desc[4] = "Clave Fuerte";
		desc[5] = "Clave Muy Fuerte";

		var score   = 0;
	
		//if password bigger than 6 give 1 point
		if (password.length >= 6) score++;
	
		//if password has both lower and uppercase characters give 1 point	
		if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;
	
		//if password has at least one number give 1 point
		if (password.match(/\d+/)) score++;
	
		//if password has at least one special caracther give 1 point
		if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;
	
		//if password bigger than 12 give another 1 point
		if (password.length >= 10) score++;

		 document.getElementById("passwordDescription").innerHTML = desc[score];
		 document.getElementById("passwordDescription").className = "passwordText";
		 document.getElementById("passwordStrength").className = "strength" + score;
		 document.getElementById("fortaleza").className = score;
		 document.getElementById("fortaleza").value = score;
		// alert('Puntaje: '+score);
		 return score;
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
	<script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>">
	</script>
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
<body >
<br><br>

<?php

if ($tipodato == 1)
{	//Nuevo Dato
?>
<form action="<?= "new_usuarios.php"; ?>" name="form" method="post" onSubmit="return valida_campos();">	
	<table border="3" align="center" width="50%" >	
		<tr>
			<td colspan="4" align="center" class= "tabla_s1_td_t1" >
				<b>Usuarios</b>			
			</td>
		</tr>
		<tr>
			<td width="40%" class="Tabla_Label">
				id Usuario			</td>
			<td width="60%" class="tabla_s1_td_c1">
				Autogenerado	
			</td>
		</tr>
		
		<tr>
			<td width="40%" class="Tabla_Label">
				Nombre de Usuario			
			</td>
			<td width="60%" >
				<input type="text" name="nombre" maxlength="60" size="60">
			</td>
		</tr>

		<tr>
			<td width="40%" class="Tabla_Label">
				Login			
			</td>
			<td width="60%" >
				<input type="text" name="login" maxlength="20" size="20">
			</td>
		</tr>
		<tr>
			<td width="40%" class="Tabla_Label">
				Lista Precio			
			</td>
			<td width="60%" >
				<input type="text" name="price_list" maxlength="4" size="10">
			</td>
		</tr>

		<tr>
			<td width="40%" class="Tabla_Label">
				Perfil
			</td>
			<td width="60%" >
				<select name="idperfil" style="width:120px;">
					<option value=""></option>
					<?php 
					$sql  = "Select idperfil, desperfil From perfiles";
					$result = $conexionMysql->db->Execute($sql);
					while ($row = $result->FetchNextObj())
					{
					?>
						<option value="<?= $row->idperfil; ?>"><?= $row->desperfil; ?></option>
					<?php
					}
					?>
				</select>
			</td>
		</tr>

		<tr>
			<td width="40%" class="Tabla_Label">
				Email			
			</td>
			<td width="60%" >
				<input type="text" name="email" maxlength="80" size="60">
			</td>
		</tr>
		
		<tr>
			<td width="50%" class="Tabla_Label"><div align="left">Clave</div></td>
            <td width="50%" class="Tabla_Datos"><div align="left">
			<input name='password1' type='password' id="password1" size='20' maxlength='16' onKeyUp="passwordStrength(this.value)">
			    <input type="hidden" name="fortaleza" id="fortaleza">
            </div></td>
        </tr>
		<tr>
		  <td class="Tabla_Label">Nivel de Fortaleza</td>
		  <td>
		  	<div id="passwordDescription"><font size="1" style="font-family:Arial, Helvetica, sans-serif">Clave no ingresada</font></div> 
			<div id="fortaleza"></div>
			<div id="passwordStrength" class="strength0"></div>
		  </td>
	  	</tr>
		<tr>
			<td width="45%" class="Tabla_Label"><div align="left">Clave</div></td>
            <td width="55%" class="Tabla_Datos"><div align="left"><input name='password2' type='password' id="password2" size='20' maxlength='16' >
            </div></td>
        </tr>

        <tr>
			<td width="40%" class="Tabla_Label">
				Admin			
			</td>
			<td width="60%" >
				<select name="admin" />
					<option value="N">NO</option>
					<option value="Y">SI</option>
				</select>
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
{	// SI TIPO DE DATO ES DIFERENTE A 1

$sql  = "SELECT * FROM usuarios";
$sql .= " WHERE idusuario = '$idusuario'";
$result = $conexionMysql->db->Execute($sql);
$row = $result->FetchNextObj();
?>

<form action="<?= "new_usuarios.php"; ?>" name="form" method="post" onSubmit="return valida_campos();">	
	<table border="3" align="center" width="50%" >	
		<tr>
			<td colspan="4" align="center" class= "tabla_s1_td_t1" >
				<b>Usuarios</b>			
			</td>
		</tr>
		<tr>
			<td width="40%" class="Tabla_Label">
				id Usuario			</td>
			<td width="60%" class="tabla_s1_td_c1">
				<?= $row->idusuario; ?>	
				<input type="hidden" name="idusuario" value="<?= $row->idusuario; ?>">
			</td>
		</tr>
		
		<tr>
			<td width="40%" class="Tabla_Label">
				Nombre de Usuario			
			</td>
			<td width="60%" >
				<input type="text" name="nombre" maxlength="60" size="60" value ="<?= $row->nombre; ?>">
			</td>
		</tr>

		<tr>
			<td width="40%" class="Tabla_Label">
				Login			
			</td>
			<td width="60%" >
				<input type="text" name="login" maxlength="20" size="20" value="<?= $row->login; ?>" readonly />
			</td>
		</tr>
		<tr>
			<td width="40%" class="Tabla_Label">
				Lista Precio			
			</td>
			<td width="60%" >
				<input type="text" name="price_list" maxlength="4" size="10" value="<?= $row->price_list; ?>" />
			</td>
		</tr>
		<tr>
			<td width="40%" class="Tabla_Label">
				Perfil
			</td>
			<td width="60%" >
				<select name="idperfil" style="width:120px;">
					<option value=""></option>
					<?php 
					$sql  = "Select idperfil, desperfil From perfiles";
					$result = $conexionMysql->db->Execute($sql);
					while ($row_1 = $result->FetchNextObj())
					{
						if($row->idperfil == $row_1->idperfil)
						{	?>
							<option value="<?= $row_1->idperfil; ?>" selected><?= $row_1->desperfil; ?></option>
							<?php
						}
						else{
							?>
							<option value="<?= $row_1->idperfil; ?>"><?= $row_1->desperfil; ?></option>
							<?php
						}
					}
					?>
				</select>
			</td>
		</tr>

		<tr>
			<td width="40%" class="Tabla_Label">
				Email			
			</td>
			<td width="60%" >
				<input type="text" name="email" maxlength="80" size="60" value="<?= $row->email; ?>">
			</td>
		</tr>
		
		<tr>
			<td width="40%" class="Tabla_Label">
				Admin			
			</td>
			<td width="60%" >
				<select name="admin" />
				<?php if($row->admin == 'Y'){
				?>
					<option value="Y" selected>SI</option>
					<option value="N" >NO</option>
				<?php	
				}else{
				?>
					<option value="Y">SI</option>
					<option value="N" selected>NO</option>
				<?php	
				}	?>
					
					
				</select>
			</td>
		</tr>

		<tr>
			<td width="40%" class="Tabla_Label">
				Campo Precio venta			
			</td>
			<td width="60%" >
				<select name="campoextra1" />
				<?php if($row->campoextra1 == 'Y'){
				?>
					<option value="Y" selected>SI</option>
					<option value="N" >NO</option>
				<?php	
				}else{
				?>
					<option value="Y">SI</option>
					<option value="N" selected>NO</option>
				<?php	
				}	?>
					
				</select>
			</td>
		</tr>


		<!--tr>
			<td width="40%" class="Tabla_Label">
				Sociedades
			</td>
			<td width="60%" class="tabla_s1_td_c1">
				<?php 
					$soc_actual = "";
					$sql  = "Select j0.idcia, j2.idsoc, j2.cmpname from companiasxusuarios as j0";
					$sql .= " Inner Join usuarios as j1 on j0.login = j1.login";
					$sql .= " inner Join srgc as j2 on j0.idcia = j2.idsoc";
					$sql .= " Where j0.login = '$row->login'";
					//echo "sql: ".$sql;
					$result = $conexionMysql->db->Execute($sql);
					while($row_2 = $result->FetchNextObj())
					{ 
						$soc_actual .= "'". $row_2->idcia . "',";
					 ?>
					<input type="checkbox" name="sociedad[]" value="<?= $row_2->idsoc; ?>" checked><?= substr($row_2->cmpname,0,20); ?>
						<br/>
					<?php
					}
					if(substr($soc_actual,-1) == ",")
					{
						$soc_actual = substr($soc_actual, 0, strlen($soc_actual)-1);
					}
					

					
					$sql  = "SELECT * FROM srgc";
					$sql .= " WHERE activo = 'Y'"; 
					if (trim($soc_actual) != ''){
						$sql .= " And idsoc Not In ($soc_actual)";	
					}
					
					$result = $conexionMysql->db->Execute($sql);
					while($row_1 = $result->FetchNextObj())
					{ 
				?>
						<input type="checkbox" name="sociedad[]" value="<?= $row_1->idsoc; ?>"><?= substr($row_1->cmpname,0,20); ?>
						<br/>
						
				<?php
					}
				?>
				
			</td>
		</tr-->

		<tr>
			<td width="40%" class="Tabla_Label">
				Estado	
			</td>
			<td width="60%">
				<select name="activo">
				<?php 
				if($row->activo == 'Y'){
				?>	
					<option value="Y" selected>Activo</option>
					<option value="N" >Inactivo</option>
				<?php	
				} else{
				?>	
					<option value="Y" >Activo</option>
					<option value="N" selected>Inactivo</option>
				<?php 
				}
				?>	
				
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
<table border="0" align="center" >
	<tr>
		<td align="center" onClick="javascript:location.href='md_usuarios.php';" ><img src="<? echo $gloRutaPublica . "/imagenes/volver.png"; ?>" width="40" height="50" alt="Volver" style="cursor:pointer">
		</td>
	</tr>
</table>	

<?php
$conexionMysql->cerrar();
?>
</body>
</html>