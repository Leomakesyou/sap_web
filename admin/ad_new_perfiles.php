<?php session_start();
 header("Cache-control: no-cache");
  require_once('../conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 include ("../conexion/Conect_DB.php"); 
 
$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

$Codperfil = $_GET['per'];
$tipodato = $_GET['tipodato'];

?>

<SCRIPT type="text/javascript">
	   
	   function desplegar_capa1(Lay)
	{
 	Cab=eval(Lay.id)
 	with (Cab.style) 
 		if (display=="none")
    		display="" 
   		else 
    		display="none" 
	}
	   
	   function valida_campos() 
		{
			
			
			if (document.form.desperfil.value == '')
			{
				alert("Ingrese el Nombre del Perfil");
				document.form.desperfil.focus();
				return false;
			}
			
			if (document.form.obsperfil.value == '')
			{
				alert("Ingrese una Observación para el Perfil");
				document.form.obsperfil.focus();
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
		
		function carga ()
		{
				//alert("Carga " + <?= $tipodato; ?>);
		}
		
</script>

<html>
<head>
<title>Perfiles del Sistema</title>

	<LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_admin.css"; ?>" type=text/css rel=stylesheet>
	<script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>
	<title><?php echo $gloNombrePublica . " " . $gloNombreCliente ?></title>
		
</head>
<body vlink="<?= $Color_Celda2; ?>" link="<?= $Color_Celda2; ?>" onLoad="carga();">
<br><br>

<?php

if ($tipodato == 1)
{	//SI ES UN PERFIL NUEVO
	
	$Codperfil = 2;
	

?>
<form action="<?= "new_perfiles.php"; ?>" name="form" method="post" onSubmit="return valida_campos();">	
	<table border="3" align="center" width="70%" >	
		<td colspan="4" align="center" class= "tabla_s1_td_t1" >
				<b>Perfiles</b>			
			</td>
		<tr>
			<td width="30%" class="Tabla_Label">
				<b>Id Perfil</b>	</td>
			<td width="70%" class="tabla_s1_td_c1">
				Autogenerado
		</tr>
		<tr>
			<td width="30%" class="Tabla_Label">
				<b>Nombre Perfil</b> 	</td>
			<td width="70%">
				<input type="text" name="desperfil" size="30">	</td>
		</tr>
		<tr>
			<td width="30%" class="Tabla_Label">
				<b>Observacion del Perfil</b>	</td>
			<td width="70%">
				<textarea name="obsperfil" cols="50"></textarea>	</td>
		</tr>
		<tr>
			<td width="30%" class="Tabla_Label">
				Sociedades
			</td>
			<td width="70%" >
				<?php 
					$sql  = "SELECT * FROM srgc";
					$sql .= " WHERE activo = 'Y'";
					$result = $conexionMysql->db->Execute($sql);
					while($row = $result->FetchNextObj())
					{ 
				?>
						<input type="checkbox" name="sociedad[]" value="<?= $row->idsoc; ?>"><?= substr($row->cmpname,0,20); ?>
						<br/>
						
				<?php
					}
				?>
				
			</td>
		</tr>
		</table>
		
		<table border="3" align="center" width="70%" >
			
			<tr>
				<td colspan="10" class="Tabla_Label">
					Seleccione las Aplicaciones
				</td>
			</tr>	
			
			<?php
	
	$sql  = "Select * ";
	$sql .= " From menu_modulos ";
	$sql .= " Where activo = 'Y'";
//	$sql = $sql . " INNER JOIN modulos_sistema as J1 ON J0.codaplicacion = J1.codaplicacion";
	//$sql = $sql . " ORDER BY J0.codaplicacion";
	$result = $conexionMysql->db->Execute($sql);
		$reg = 0;
		$reg1 = 0;
		$fila = 0;
	while($row = $result->FetchNextObj())
	{	//Muestra el Historico de la PQR Consultada
		$reg = $reg + 1;
		$fila = $fila + 1;
	?>
		
		<tr id="letra" style="cursor:pointer">
			<td width="95%" align="left" class="Tabla_Datos" onClick="desplegar_capa1(<? echo "celda".$fila; ?>);" onMouseOver="this.style.background='#FFFFCC'" onMouseOut="this.style.background='#E8E8E8'">
				<?= $row->idmodulo . " . " . $row->desmodulo; ?>			</td>
			<td align="center" class="Tabla_Datos" >
				<input type="checkbox" name="modulo[<?= $reg; ?>]" value="<?= $row->idmodulo; ?>"> 
		  </td>
		</tr>
		
					<tr id="<? echo "celda".$fila; ?>" style="display: none">
						<td colspan="6">
							<table border="0" style="border-collapse:collapse" width="100%">
								
								<?php 
								$sql  = "SELECT J0.* FROM menu_aplicaciones as J0";
								$sql .= " INNER JOIN menu_modulos as J1 ON J0.idmodulo = J1.idmodulo";
								$sql .= " WHERE J0.idmodulo = '$row->idmodulo'";
								$sql .= " ORDER BY J1.idmodulo";
								//echo "<br>SQL:".$sql;
								$result_1 = $conexionMysql->db->Execute($sql);
									
								while($row_1 = $result_1->FetchNextObj())
								{
									$reg1 = $reg1 +1;
								?> 
								
								<tr >
									<td width="10%">
									  <p>&nbsp;</p>
								    </td>
									<td width="81%" align="justify" class="Tabla_SubTitulo">
										<?= $row_1->idaplicacion . " . " . $row_1->desaplicacion; ?>
									</td>
									<td width="9%" align="center" class="Tabla_SubTitulo">
										<input type="checkbox" name="aplicacion[<?= $reg1; ?>]" value="<?= $row_1->idaplicacion; ?>">
										
								  </td>
									
								</tr>
								<?php } //FIN DEL WHILE INTERNO?>
							</table>
						</td>
					</tr>
			
					

	<?php } //fin del while para mostrar el historico?> 			
			
			
		</table>
		
		
		<table border="3" align="center" width="70%" >
		<tr>
				<td colspan="2" class="Tabla_Datos"><div align="center"></div>
					<input type="hidden" name="tipodato" value="<?= $tipodato ?>">
					<div align="center">            					
	  					<input name="submitButton" type="submit" class="Boton_Submit" id="submitButton" style="Width: 80px;" value="Ingresar" onMouseOver="javascript:mOvr(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOVER,'','');" onMouseOut="javascript:mOut(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOUT,'','');" >
						<input type="reset" value= "Limpiar" style="Width: 80px;" class="Boton_Submit" onMouseOver="javascript:mOvr(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOVER,'','');" onMouseOut="javascript:mOut(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOUT,'','');">
					</div>
				</td>
		</tr>
						
	</table>
</form>	

<?php 
}	//FIN DEL IF PARA EL TIPO DE DATO NUEVO

if ($tipodato == '2')
{	 //SI ES UN PERFIL PARA MODIFICAR
	
	$sql = "SELECT *  ";
	$sql = $sql . " FROM perfiles ";
	$sql = $sql . " where idperfil = '$Codperfil'";
	$sql = $sql . " ";
	//echo "<br>Perfil: ".$sql;
	$result = $conexionMysql->db->Execute($sql);
	$row_1=$result->FetchNextObj();

?>
<form action="<?= "new_perfiles.php"; ?>" name="form" method="post" onSubmit="return valida_campos();">	
	<table border="3" align="center" width="70%" >	
		<td colspan="4" align="center" class= "tabla_s1_td_t1" >
				<b>Perfiles</b>			
			</td>
		<tr>
		<tr>
			<td width="30%" class="Tabla_Label">
				<b>Id Perfil</b>	
			</td>
			<td width="70%">
				<input type="text" name="perfil" size="5" readonly value="<?= $Codperfil; ?>">	</td>
		</tr>
		<tr>
			<td width="30%" class="Tabla_Label">
				<b>Nombre Perfil</b> 	</td>
			<td width="70%">
				<input type="text" name="desperfil" size="30" value="<?= $row_1->desperfil; ?>">	</td>
		</tr>
		<tr>
			<td width="30%" class="Tabla_Label">
				<b>Observacion del Perfil</b>	</td>
			<td width="70%">
				<textarea name="obsperfil" cols="50"><?= $row_1->obsperfil; ?></textarea>	</td>
		</tr>
		<?php
		

		?>
		<tr>
			<td width="40%" class="Tabla_Label">
				Sociedades
			</td>
			<td width="60%" class="tabla_s1_td_c1">
				<?php 
					$soc_actual = "";
					$sql  = "Select j0.idcia, j2.idsoc, j2.cmpname from companiasxperfiles as j0";
					$sql .= " Inner Join perfiles as j1 on j0.idperfil = j1.idperfil";
					$sql .= " inner Join srgc as j2 on j0.idcia = j2.idsoc";
					$sql .= " Where j0.idperfil = '$Codperfil'";
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
		</tr>
		</table>
		
		<table border="3" align="center" width="70%" >
			
			<tr>
				<td colspan="10" class="Tabla_Label">
					Seleccione las Aplicaciones
				</td>
			</tr>	
			
			<?php
	
	$sql = "SELECT J0.*";
	$sql = $sql . " FROM menu_modulos as J0";
	$sql .= " WHERE J0.activo = 'Y'";
//	$sql = $sql . " INNER JOIN modulos_sistema as J1 ON J0.codaplicacion = J1.codaplicacion";
	$sql = $sql . " ORDER BY J0.idmodulo";
	$result = $conexionMysql->db->Execute($sql);
	$fila = 0;
	$reg = 0;
	$reg1 = 0;
	while($row = $result->FetchNextObj())
	{	//Muestra el Historico de la PQR Consultada
		$fila = $fila + 1;
		$reg = $reg + 1;
		$sql  = "SELECT * ";
		$sql .= " FROM menu_modulos ";
		$sql .= " WHERE activo = 'Y'";
		//echo "<br>SQL: ".$sql;
		$result_2 = $conexionMysql->db->Execute($sql);
		
	?>
		
		<tr id="letra" style="cursor:pointer" onClick="desplegar_capa1(<? echo "celda".$fila; ?>);" onMouseOver="this.style.background='#FFFFCC'" onMouseOut = "this.style.background='#FFFFFF'">
			<td width="91%" align="left" class="Tabla_Datos">
				<?= $row->idmodulo . " . " . $row->desmodulo; ?>			</td>
			<td width="10%" align="center">
			<?php
				if ($row_2 = $result_2->FetchNextObj())
				{ ?>
				<input type="checkbox" name="modulo[<?= $reg; ?>]" value="<?= $row->idmodulo; ?>" checked>
				<?php } 
				else{	?>
				<input type="checkbox" name="modulo[<?= $reg; ?>]" value="<?= $row->idmodulo; ?>">
				<?php } ?>
				 
		  </td>
		</tr>
		
					<tr id="<? echo "celda".$fila; ?>" style="display: none">
						<td colspan="6">
							<table border="0" style="border-collapse:collapse" width="100%">
								
								<?php 
								
								$sql  = "SELECT J0.* FROM menu_aplicaciones as J0";
								$sql .= " INNER JOIN menu_modulos as J1 ON J0.idmodulo = J1.idmodulo";
								$sql .= " WHERE J0.idmodulo = '$row->idmodulo'";
								$sql .= " ORDER BY J0.idaplicacion";

								$result_1 = $conexionMysql->db->Execute($sql);
									
								while($row_1 = $result_1->FetchNextObj())
								{   $reg1 = $reg1 +1;
								
									$sql = "SELECT * ";
									$sql = $sql . " FROM menu_aplicacionesxperfil ";
									$sql = $sql . " WHERE idaplicacion = '$row_1->idaplicacion'";
									$sql = $sql . " and idperfil = '$Codperfil'";
									//echo "<br>SQL: ".$sql;
									$result_2 = $conexionMysql->db->Execute($sql);
								?> 
								
								<tr id="letra">
									<td width="10%">
									  <p>&nbsp;</p>
								    </td>
									<td width="81%" align="justify" class="Tabla_SubTitulo">
										<?= $row_1->idaplicacion . " . " . $row_1->desaplicacion; ?>	</td>
									<td width="9%" align="center" class="Tabla_SubTitulo">
									<?php
									if ($row_2 = $result_2->FetchNextObj())
									{ ?>
										<input type="checkbox" name="aplicacion[<?= $reg1; ?>]" value="<?= $row_1->idaplicacion; ?>" checked>
										
									<?php } 
									else{	?> 
								  		<input type="checkbox" name="aplicacion[<?= $reg1; ?>]" value="<?= $row_1->idaplicacion; ?>">
								  		
									<?php } ?>  
								  </td>
									
								</tr>
								<?php } //FIN DEL WHILE INTERNO?>
							</table>
						</td>
					</tr>

					
			
	<?php } //fin del while para mostrar el historico?> 			
			
			
		</table>
		
		
		<table border="3" align="center" width="70%" >
		<tr>
			<td colspan="2" class="Tabla_Datos"><div align="center"></div>
				<input type="hidden" name="tipodato" value="<?= $tipodato ?>">
				<div align="center">            					
					<input name="submitButton" type="submit" class="Boton_Submit" id="submitButton" style="Width: 80px;" value="Actualizar" onMouseOver="javascript:mOvr(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOVER,'','');" onMouseOut="javascript:mOut(this,COLOR_BOTON_SUBMIT_ADMIN_MOUSEOUT,'','');" >
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
		<td align="center" onClick="javascript:location.href='md_perfiles.php'" ><img src="<? echo $gloRutaPublica . "/imagenes/volver.png"; ?>" width="40" height="50" alt="Volver" style="cursor:pointer">
		</td>
	</tr>
</table>	

<?php
$conexionMysql->cerrar();
?>
</body>
</html>


