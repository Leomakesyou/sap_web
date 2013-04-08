<?
$loginerr = -1;
$totalIntentosIngreso = 4;
if (isset($_POST[login]) && isset($_POST[password]) && $_POST[login] <> "" && $_POST[password] <> "" && $_POST[idioma] <> "" && $_POST[perfil] <> "" && $_POST[captcha_code] <> "")	{

	//antes de conectar validar el código de seguridad
	$securimage = new Securimage();
	
	if ($securimage->check($_POST[captcha_code]) == true) {
	
		$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

		//validar estado usuario
		if($_POST[perfil] == 'usuario') {
			$sql = "SELECT * FROM usuarios_sistema\n";
		}
		//intermediario
		elseif($_POST[perfil] == 'cliente') {
			$sql = "SELECT * FROM usuarios_clientes\n";
		}
		//cliente final
		elseif($_POST[perfil] == 'final') {
			$sql = "SELECT * FROM usuarios_finales\n";
		}
		
		$sql.= "WHERE Login='" . $_POST[login] . "'\n";

		//
		if (! $resultset = $conexionMysql->db->Execute($sql))
			$conexionMysql->Error($gloRutaErrorAdmin, "Mensaje : 1. ERROR EJECUTANDO CONSULTA", $_SERVER[SCRIPT_FILENAME]);
	
		//calcular el numero de filas obtenidas
		$numfilas = $resultset->RecordCount();

		if($numfilas > 0) {
		
			$row0 = $resultset->FetchNextObj();
			$loginerr = 0;
			
			//validar si el usuario está activo
			if($row0->Estado=='Bloqueado') {
				$loginerr = 1;
			}

			//si usuario activo se valida clave
			if($row0->Estado=='Activo' || $row0->Estado=='NC') {
				$loginerr = 0;

				//clave inválida
				if($row0->Clave != md5($_POST[password])) {
					validarNumeroIntentos($row0->IdUsuario, $row0->NumIntentos, $_POST[perfil], $conexionMysql);

					$loginerr = 2;
					$totalIntentosIngreso = $totalIntentosIngreso - $row0->NumIntentos;
				}
		
				//usuario con clave válida
				elseif($row0->Clave == md5($_POST[password])) {
				
					if($row0->Estado=='Activo') {
					
						//validar si la clave se vence hoy
						if($row0->FechaCambio == date("Y-m-d")) {
							$conexionMysql->cerrar();
							header("location: cambio.php?idUsuario=$row->IdUsuario");
							exit;
						}

						//tipo de usuario
						if($_POST[perfil] == 'usuario'){
							$sql = "SELECT usuarios_sistema.IdUsuario, usuarios_sistema.IdPerfil, usuarios_sistema.IdSucursal, \n";
							$sql.= "usuarios_sistema.Nombre_Usuario, usuarios_sistema.Apellidos_Usuario,\n";
							$sql.= "perfiles_usuario.Nombre_Perfil,\n";
							$sql.= "sucursal_empresa.Nombre_Sucursal\n";
							$sql.= "FROM usuarios_sistema\n";
							$sql.= "INNER JOIN perfiles_usuario ON usuarios_sistema.IdPerfil=perfiles_usuario.IdPerfil\n";
							$sql.= "INNER JOIN sucursal_empresa ON usuarios_sistema.IdSucursal=sucursal_empresa.IdSucursal\n";
							$sql.= "WHERE usuarios_sistema.Login='" . $_POST[login] . "' AND usuarios_sistema.Clave='" . md5($_POST[password]) . "'\n";
							$sql.= "AND usuarios_sistema.Estado='Activo'\n";
						}
						elseif($_POST[perfil] == 'cliente'){

							$sql = "SELECT usuarios_clientes.IdUsuario, usuarios_clientes.IdPerfil, usuarios_clientes.IdSucursal, usuarios_clientes.Razon_Social, usuarios_clientes.Codigo_Interno,\n";
							$sql.= "perfiles_clientes.Nombre_Perfil,\n";
							$sql.= "sucursal_empresa.Nombre_Sucursal\n";
							$sql.= "FROM usuarios_clientes\n";
							$sql.= "INNER JOIN perfiles_clientes ON usuarios_clientes.IdPerfil=perfiles_clientes.IdPerfil\n";
							$sql.= "INNER JOIN sucursal_empresa ON usuarios_clientes.IdSucursal=sucursal_empresa.IdSucursal\n";
							$sql.= "WHERE usuarios_clientes.Login='" . $_POST[login] . "' AND usuarios_clientes.Clave='" . md5($_POST[password]) . "'\n";
							$sql.= "AND usuarios_clientes.Estado='Activo'\n";
						}
						//
						elseif($_POST[perfil] == 'final'){

							$sql = "SELECT usuarios_finales.IdUsuario, usuarios_finales.IdPerfil, usuarios_finales.IdSucursal, usuarios_finales.Razon_Social, usuarios_finales.Codigo_Interno,\n";
							$sql.= "perfiles_finales.Nombre_Perfil,\n";
							$sql.= "sucursal_empresa.Nombre_Sucursal\n";
							$sql.= "FROM usuarios_finales\n";
							$sql.= "INNER JOIN perfiles_finales ON usuarios_finales.IdPerfil=perfiles_finales.IdPerfil\n";
							$sql.= "INNER JOIN sucursal_empresa ON usuarios_finales.IdSucursal=sucursal_empresa.IdSucursal\n";
							$sql.= "WHERE usuarios_finales.Login='" . $_POST[login] . "' AND usuarios_finales.Clave='" . md5($_POST[password]) . "'\n";
							$sql.= "AND usuarios_finales.Estado='Activo'\n";
						}
						
						if (! $resultset1 = $conexionMysql->db->Execute($sql))
							$conexionMysql->Error($gloRutaErrorAplicacion, "Mensaje : 3. ERROR EJECUTANDO CONSULTA", $_SERVER[SCRIPT_FILENAME]);
					
						// calcular el numero de filas obtenidas
						$numeroUsuario = $resultset1->RecordCount();
	
						$row1 = $resultset1->FetchNextObj();
						$loginerr = 0;
						
						$sql = "SELECT NombreUsuario, Email FROM usuario_administrador\n";
						$sql.= "WHERE Activo='Si'\n";
						//
						if (! $resultset2 = $conexionMysql->db->Execute($sql))
							$conexionMysql->Error($gloRutaErrorAplicacion, "Mensaje : 4. ERROR EJECUTANDO CONSULTA", $_SERVER[SCRIPT_FILENAME]);
					
						//
						$sql = "SELECT Correo_Proveedor, Web_Proveedor FROM datos_empresa\n";
						//
						if (! $resultset3 = $conexionMysql->db->Execute($sql))
							$conexionMysql->Error($gloRutaErrorAplicacion, "Mensaje : 5. ERROR EJECUTANDO CONSULTA", $_SERVER[SCRIPT_FILENAME]);
				
						//
						$sql = "SELECT datos_empresa.Nombre_Empresa, datos_empresa.Numero_Documento, datos_empresa.Imagen, \n";
						$sql.= "tipo_documento_identificacion.Abreviatura\n";
						$sql.= "FROM datos_empresa\n";
						$sql.= "INNER JOIN tipo_documento_identificacion ON datos_empresa.IdTipo_Documento=tipo_documento_identificacion.IdTipo_Documento\n";
						//
						if (! $resultset4 = $conexionMysql->db->Execute($sql))
							$conexionMysql->Error($gloRutaErrorAplicacion, "Mensaje : 6. ERROR EJECUTANDO CONSULTA", $_SERVER[SCRIPT_FILENAME]);
							
						//
						$sql = "SELECT Nombre_Sucursal, Direccion_1_Sucursal, Telefono_Pbx_Sucursal, Telefono_Fax_Sucursal\n";
						$sql.= "FROM sucursal_empresa\n";
						$sql.= "WHERE IdSucursal='" . $row1->IdSucursal . "'\n";
						//
						if (! $resultset5 = $conexionMysql->db->Execute($sql))
							$conexionMysql->Error($gloRutaErrorAplicacion, "Mensaje : 7. ERROR EJECUTANDO CONSULTA", $_SERVER[SCRIPT_FILENAME]);
							
						//creando la sesion
						session_start();
				  
						$_SESSION['loginUsuario'] = $row0->Login;
						$_SESSION['sesIdUsuario'] = $row1->IdUsuario;
						$_SESSION['sesIdPerfil'] = $row1->IdPerfil;
						$_SESSION['sesTipoUsuario'] = $_POST[perfil];
						
						if($_POST[perfil] == 'usuario')
							$_SESSION['sesNombreUsuario'] = substr($row1->Nombre_Usuario . " " . $row1->Apellidos_Usuario, 0, 30);
						
						elseif($_POST[perfil] == 'cliente' || $_POST[perfil] == 'final'){
							$_SESSION['sesNombreUsuario'] = substr($row1->Razon_Social, 0, 30);
							$_SESSION['sesCodInternoUsuario'] = $row1->Codigo_Interno;
						}
				
						$_SESSION['sesIdioma'] = $_POST[idioma];		
						$_SESSION['sesNombrePerfil'] = $row1->Nombre_Perfil;
						$_SESSION['sesNombreSucursal'] = $row1->Nombre_Sucursal;
						
						$row = $resultset2->FetchNextObj();
								
						$_SESSION['sesNombreAdministrador'] = $row->NombreUsuario;
						$_SESSION['sesEmailAdministrador'] = $row->Email;
				
						$row = $resultset3->FetchNextObj();
						
						$_SESSION['sesEmailProveedor'] = $row->Correo_Proveedor;
						$_SESSION['sesWebProveedor'] = $row->Web_Proveedor;		
						
						$row = $resultset4->FetchNextObj();
						
						$_SESSION['sesImagen'] = $row->Imagen;
				
						$row_1 = $resultset5->FetchNextObj();		
				
						//Escribir archivo encabezado
							if($_POST[perfil] == 'usuario')
								$cadena= $gloPathAplicacionMenus . "/" . $_SESSION['sesIdPerfil'] . "/" . $_SESSION['sesIdUsuario'] . "encabezado.txt";
							elseif($_POST[perfil] == 'cliente')
								$cadena= $gloPathAplicacionMenusClientes . "/" . $_SESSION['sesIdPerfil'] . "/" . $_SESSION['sesIdUsuario'] . "encabezado.txt";
							elseif($_POST[perfil] == 'final')
								$cadena= $gloPathAplicacionMenusFinales . "/" . $_SESSION['sesIdPerfil'] . "/" . $_SESSION['sesIdUsuario'] . "encabezado.txt";

						$fp = fopen($cadena, "w+");
						fputs($fp, $row->Nombre_Empresa ."\r\t\t");
						fputs($fp, $row->Abreviatura . " " . $row->Numero_Documento ."\r\n");
						fputs($fp, $row_1->Nombre_Sucursal . "\r\n");		
						fputs($fp, $row_1->Direccion_1_Sucursal . "\r\n");
						fputs($fp, "PBX: " . $row_1->Telefono_Pbx_Sucursal . " FAX:" . $row_1->Telefono_Fax_Sucursal . "\r\n");
						//
						fclose($fp);

						//actualizar ingreso
						actualizarIngreso($row0->IdUsuario, $_POST[perfil], $conexionMysql);
						
						
						//registrar auditoria
						
						$conexionMysql->cerrar();

						header("location: ingreso.php");
					}

					//
					elseif($row0->Estado=='NC') {

						$conexionMysql->cerrar();
						header("location: cambio.php?idUsuario=$row0->IdUsuario&perfilUsuario=$_POST[perfil]");
						exit;
					}
				}
			}
		}
		
		//usuario no valido
		else
		{
			$loginerr = 2;
			$conexionMysql->cerrar();
		}
	
	}
	//código de seguridad no válido
	else {
		$loginerr = 4;
	}
	
}
else
{
	session_start();
	session_unset();	
}

//////////////////////////////////////////////////////////////////////////////////////////////
function validarNumeroIntentos($idUsuario, $numeroIntentos, $tipoUsuario, $conexion){

	$numeroIntentos = $numeroIntentos + 1;

	if($tipoUsuario == 'usuario') {
		$sql = "UPDATE usuarios_sistema\n";
	}
	elseif($tipoUsuario == 'cliente') {
		$sql = "UPDATE usuarios_clientes\n";
	}
	elseif($tipoUsuario == 'final') {
		$sql = "UPDATE usuarios_finales\n";
	}

	//
	if($numeroIntentos < 4) {
		$sql.= "SET NumIntentos = " . $numeroIntentos . "\n";
	}
	elseif($numeroIntentos >= 4) {
		$sql.= "SET NumIntentos = " . $numeroIntentos . ",\n";
		$sql.= "Estado='Bloqueado'\n";
	}
	$sql.= "WHERE IdUsuario=" . $idUsuario . "\n";
	
	if (!$conexion->db->Execute($sql))
		$conexion->Error($gloRutaErrorAdmin, "Mensaje : 2. ERROR EJECUTANDO CONSULTA", $_SERVER[SCRIPT_FILENAME]);

}

//////////////////////////////////////////////////////////////////////////////////////////////
function actualizarIngreso($idUsuario, $tipoUsuario, $conexion){

	if($tipoUsuario == 'usuario') {
		$sql = "UPDATE usuarios_sistema\n";
	}
	elseif($tipoUsuario == 'cliente') {
		$sql = "UPDATE usuarios_clientes\n";
	}
	elseif($tipoUsuario == 'final') {
		$sql = "UPDATE usuarios_finales\n";
	}

	$sql.= "SET NumIntentos = 0\n";
	$sql.= "WHERE IdUsuario=" . $idUsuario . "\n";
	
	if (!$conexion->db->Execute($sql))
		$conexion->Error($gloRutaErrorAdmin, "Mensaje : 8. ERROR EJECUTANDO CONSULTA", $_SERVER[SCRIPT_FILENAME]);

}

?>