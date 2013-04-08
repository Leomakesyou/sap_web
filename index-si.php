<?php session_start();
 header("Cache-control: no-cache");
 $gloRutaPublica= "http://" . $_SERVER[HTTP_HOST] . "/Sap_Web";
 $gloRutaSecureImage = $gloRutaPublica . "/includes/securimage";
 $listaValidacionesLogin['1'] = "Ingrese los Datos Faltantes";
 $listaCadenasLogin['1'] ="";
 $listaCadenasLogin['2'] ="Nombre de Usuario";
 $listaCadenasLogin['3'] ="Clave";
 $listaCadenasLogin['4'] ="";
 $listaCadenasLogin['5'] ="Imagen de Seguridad";
 $listaCadenasLogin['6'] = "C&oacute;digo de Seguridad";
 $listaBotonesTrasv['1'] = "Ingresar";
/*
Azul:	 	#10298C
Verde:	 	#008431
Amarillo:	#FFFF00
Gris:		#DEDBB2	
*/
error_reporting(ALL);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>.: Aplicación Sap Web :.</title>
	<link rel="icon" href="tqgroup.ico">
	<LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_extranet.css"; ?>" type=text/css rel=stylesheet>
	<script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>
	<title><?php echo $gloNombrePublica . " " . $gloNombreCliente ?></title>
	<meta charset=UTF-8 />
	<script language="JavaScript">
		function valida_campos() 
		{
 			if (document.formulario.login.value=='') 
			{
  				rc=alert('<?= $listaValidacionesLogin['1'] ?>');
  				document.formulario.login.focus();
  				return false;
 			}
 			
			if (document.formulario.password.value=='') 
			{
  				rc=alert('<?= $listaValidacionesLogin['1'] ?>');
  				document.formulario.password.focus();
  				return false;
 			}
			if (document.formulario.captcha_code.value=='') 
			{
  				rc=alert('Ingrese el código que aparece en la imagen');
  				document.formulario.captcha_code.focus();
  				return false;
 			}
 			
			document.formulario.submitButton.disabled = true;
 			return true;

		}
		//-->
	</script>
	<style type="text/css">
		#botones {

		   	padding: 10px;
		   	text-decoration: none;
		   	color: white;
		   	font-weight: bold;
		   	font-family: arial;
		   	font-size: 16px;
		   	text-shadow: 0 1px 0 black;
		   	line-height: 56px;
		   	border-right: 30px solid transparent;
		   	border-bottom: 30px solid #4c4c4c; 
		   	height: 0;
		   	display: inline-block;  	
		   }
	</style>
</head>
<body onLoad="javascript:document.formulario.login.focus();"><center>
<?php
	
	if (isset($_POST[accion]) && $_POST[login] == '')
	{
		echo "<br><center><font color=red><strong>Ingrese los Datos de Acceso</strong></font><center>";
		$_POST[accion] = "no";
	}
	$Accion = $_POST[accion];
	if (isset($Accion) && $Accion == 'Ingresar' && isset($_POST[login]))
	{	
	
		require_once ("includes/securimage/securimage.php");
		//require_once('error.php');
		$securimage = new Securimage();
		
		if ($securimage->check($_POST[captcha_code]) == true) {

			include ("conexion/Conect_DB.php");
			
			//$login = htmlspecialchars(trim(strtoupper($_POST['userlogin'])));
			$login = strtolower($_POST['login']);
			$pass = md5($_POST['password']); 
			error_reporting(ALL);

			$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
				mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());
				
				$sql  = " SELECT j0.idusuario, j0.login, j0.clave, j0.nombre, j1.idperfil, j1.desperfil, j0.fecultingreso, j0.feclimite ";
				$sql .= " FROM usuarios as j0";
				$sql .= " Inner Join perfiles as j1 on j1.idperfil = j0.idperfil";
				$sql .= " Where j0.login = '$login' and j0.clave = '$pass' and j0.activo='Y'";
				
				$result = mysql_query($sql, $link) or die (mysql_error());	
				$row = mysql_fetch_assoc($result);
				$numDatos = @mysql_num_rows($result);
				
				if ($numDatos <= 0) 
				{
					echo "<br><center><font color=red><strong>
					Usuario o Clave invalidos, Verifique el usuario y la clave introducidos
					</strong></font></center>";
				
					mysql_close($link);	
				}
				else
				{
					
						$idsesion = md5(uniqid(date("Y-m-d H:i:s")));
						//$_SESSION["idsesion"] = $idsesion;
						$FechaIng = date("Y-m-d");
						$HoraIng = date("H:i:s");
						$diripacceso = $_SERVER['REMOTE_ADDR'];
						
						if($row[fecultingreso] == "0000-00-00")
						{
							//echo "<br>Fecha 0";
							?>
							<script>
								window.location.replace("<? echo $gloRutaPublica . "/ad_cclave_usu.php?login=$login&page=index.php"; ?>");
							</script>
							<?php
							exit(); 
						}
						$fechaf1 = date("Y-m-d");	//date
						if ($row[feclimite] <=  $fechaf1)
						{
							//echo "<br>Fecha 0";
							?>
							<script>
								window.location.replace("<? echo $gloRutaPublica . "/ad_cclave_usu.php?login=$login&page=index.php"; ?>");
							</script>
							<?php
							exit();
						}

						//echo "si es usuario";
						$menu = "acceso.php";
						//$row = @mysql_fetch_array($result);
						$_SESSION["sudlogin"] = $row[login];
						//$_SESSION["sudnombre"] = $row[nombre];
						$_SESSION["sudperfil"] = $row[idperfil];
						//$_SESSION["suddesperfil"] = $row[desperfil];
						
						$sql = "UPDATE usuarios SET fecultingreso = '$FechaIng', horultingreso = '$HoraIng', ipultingreso = '$diripacceso'";
						$sql = $sql . " WHERE login='$login' ";	
						//echo "<br>C1: ".$sql;
						$result = mysql_query($sql, $link) or die (mysql_error());
						
						$sql  = "INSERT INTO logs_acceso_sistema ";
						$sql .= "(idsesion, login, fecingreso, horingreso, diripacceso)";
						$sql .= " values ('$idsesion','$login','$FechaIng','$HoraIng', '$diripacceso')";
						//echo "<br>C1: ".$sql;
						$result = mysql_query($sql, $link) or die (mysql_error());
						
						mysql_close($link) or die (mysql_error());
						?>
						<script type="text/javascript">
						location.replace("<?= $menu; ?>");
						</script>
						
					<?php 
				}
		}
		else{
			echo "<br><center><font color=red><strong>
					La imagen de Seguridad no es Valida.
					</strong></font></center>";
		}
	}
	else{
		session_unset();
		session_destroy();
	}


	if ($_SESSION['sesIdUsuario'] == "NOBODY" || $_SESSION['sesIdUsuario'] == "" || empty($_SESSION['sesIdUsuario']))
	{ ?>
	<table width='60%' align="center" cellpadding="0" class="Tabla_Uno">
		
		<tr >
			<td class="Tabla_Titulo">
				<div align="center">
				<?= "Aplicación Web - Ingreso de Datos "; ?>
				</div>
			</td>
		</tr>
		<tr class="Tabla_Encabezado">
			<td><div align="center">
			<img src="<?php echo $gloRutaPublica . "/imagenes/logo.png"; ?>" 
			width="300" height="70" alt="<?php echo $gloNombreCliente ?>"></div>
			</td>
		</tr>
	<?php
		if ($loginerr == 1) 
		{	?>
			<tr>
				<td align='center' height='2' class="Tabla_SubTitulo_Resalte"><?=$listaMensajesLogin['2'] ?></td>
			</tr>
	<? } ?>
	<?php
		if ($loginerr == 2) 
		{	?>
			<tr>
				<td align='center' height='2' class="Tabla_SubTitulo_Resalte"><?=$listaMensajesLogin['3'] . $totalIntentosIngreso . $listaMensajesLogin['4'] ?></td>
			</tr>
	<? } ?>

	<?php
		if ($loginerr == 4) 
		{	?>
			<tr>
				<td align='center' height='2' class="Tabla_SubTitulo_Resalte"><?=$listaMensajesLogin['5'] ?></td>
			</tr>
	<? } ?>
	
		<tr>
			<td id="contenedor"><div align="center">
				<form name='formulario' action="" method='post' onSubmit='return valida_campos();'>
					<table width="100%" cellspacing="4">
						<tr>
							<td width="40%" class="Tabla_Label"><div align="left">Usuario</div></td>
                            <td width="60%" class="Tabla_Datos"><div align="left"><input name='login' type='text' id="login" size='30' maxlength='30' tabindex="1"></div></td>
                        </tr>
						<tr>
							<td width="40%" class="Tabla_Label"><div align="left">Clave de Acceso</div></td>
                            <td width="60%" class="Tabla_Datos"><div align="left"><input name='password' type='password' id="password" size='30' maxlength='30' tabindex="2"></div></td>
                        </tr>
						<tr>
							<td width="40%" class="Tabla_Label"><div align="left"><?=$listaCadenasLogin['5'] ?></div></td>
                            <td width="60%" class="Tabla_Datos"><div align="left">
                              <table width="100%" >
                                <tr>
                                  <td width="90%" align="left" valign="middle"><img id="captcha" src="<?=$gloRutaSecureImage . "/securimage_show.php" ?>" alt="Imagen de Seguridad" /></td>
                                  <td width="10%" align="center" valign="middle"><a href="#" onclick="document.getElementById('captcha').src = '<?=$gloRutaSecureImage . "/securimage_show.php" ?>?' + Math.random(); document.getElementById('captcha_code').focus(); return false"><img src="<?=$gloRutaPublica . "/imagenes/refresh.gif"; ?>" alt="Recargar Imagen" width="22" height="20" border="0"></a></td>
                                </tr>
                              </table>
                            </div></td>
                        </tr>
						<tr>
							<td width="45%" class="Tabla_Label"><div align="left"><?=$listaCadenasLogin['6'] ?></div></td>
                            <td width="55%" class="Tabla_Datos"><div align="left"><input name='captcha_code' type='password' id="captcha_code" size='15' maxlength='4' tabindex="2">
                            </div></td>
                        </tr>
						
						<tr>
							<td colspan="2">            					
          						<table width="100%" >
                                  <!--tr>
                                    <td><img src="<?php echo $gloRutaPublica . "/imagenes/spacer.gif"; ?>" width="10" height="1"></td>
                                  </tr-->
                                  <tr>
                                    <td><div align="center">
                                      <input name="submitButton" type="submit" class="Boton_Submit" id="submitButton" style="Width: 80px;" value="<?=$listaBotonesTrasv['1'] ?>" onMouseOver="javascript:mOvr(this,COLOR_BOTON_SUBMIT_MOUSEOVER,'','');" onMouseOut="javascript:mOut(this,COLOR_BOTON_SUBMIT_MOUSEOUT,'','');" tabindex="4">
                                      <!-- submitButton -->
                                      <input type="hidden" name="accion" Value="Ingresar">
                                      	
                                    </div></td>
                                  </tr>
                                  
                                  <tr>
                                    <td><img src="<?php echo $gloRutaPublica . "/imagenes/spacer.gif"; ?>" width="10" height="1"></td>
                                  </tr>
                                </table>						   
                             </td>
						</tr>
					</table>
				</form>
			</td>
		</tr>

	</table>		
<?php
	}	?>
</center>
<?php 
include "extranet_pie.php";  ?>
</body>
</html>
