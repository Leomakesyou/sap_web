<?php
 header("Cache-control: no-cache");
  require_once('../conexion/conf.php');
 //include $gloIncludeAplicacion . "/extranet_definir_lenguaje.php"; 
 //se determina mediante la sesión si está cargado el administrador
 session_start();
 
 //cerrando la sesion 
 session_unset();
 session_destroy();
?>
<html>
<head>
	<LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_admin.css"; ?>" type=text/css rel=stylesheet>
	<script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>
	<title>Salida Administraci&oacute;n Sudespensa App</title>
</head>
<body onLoad="javascript: resize();">
<table width='95%' align="center" cellpadding="2" class="Tabla_Uno">
	<tr class="Tabla_Encabezado">
		<td><div align="center"><img src="<?php echo $gloRutaPublica . "/imagenes/logo_empresa.png"; ?>" width="120" height="120" alt="<?php echo "Sudespensa" ?>">
	
		</div></td>
	</tr>
	<tr class="Tabla_Titulo">
		<td><div align="center"></div></td>
	</tr>
	<tr>
		<td class="Tabla_Dos"><div align="center">
			<table width='100%' align="center">
				<tr>
    	        	<td width="50%" class="Tabla_Label"><div align="left"><?php echo "Cerrar"; ?></div></td>
					<td width="50%" class="Tabla_Datos"><div align="left"><a href="#" onClick="javascript:window.close();"><img src="<?php echo $gloRutaPublica . "/imagenes/fin.gif"; ?>" name="cerrar" width="20" height="20" border="0" align="baseline" id="cerrar" style="filter:alpha(opacity=50); -moz-opacity:0.5" onMouseover="lightup(this, 100)" onMouseout="lightup(this, 50)" alt="<?php echo $listaMsgFin['2']; ?>"></a></div></td>
				</tr>
				<tr>
    	        	<td width="50%" class="Tabla_Label"><div align="left"><?php echo "Ingresar"; ?></div></td>				
					<td width="50%" class="Tabla_Datos"><div align="left"><a href="#" onClick="javascript:location.href='index.php';"><img src="<?php echo $gloRutaPublica . "/imagenes/ingresar.gif"; ?>" name="entrar" width="20" height="20" border="0" align="baseline" id="entrar" style="filter:alpha(opacity=50); -moz-opacity:0.5" onMouseover="lightup(this, 100)" onMouseout="lightup(this, 50)" alt="<?php echo $listaMsgFin['3']; ?>"></a></div></td>
				</tr>
			</table>
		</div></td>
	</tr>
	<tr class="Tabla_Tres">
		<td><div align="left">&nbsp; </div></td>
	</tr>
</table>
<?php 
include "extranet_pie.php";  ?>
</body>
</html>