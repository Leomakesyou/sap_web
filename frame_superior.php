<?php session_start();
 header("Cache-control: no-cache");
 include $_SERVER[DOCUMENT_ROOT] . "/sap_web/conexion/conf.php"; 
 
 ?>
<html>
<head>

<style>
	label{
		
		font-family: "Helvetica", "arial";
		font-size: 1em;
		margin:2px;
		padding:2px;
	}
	#marco {
		background: url(imagenes/logo_empresa.png) no-repeat left center;
		border-radius: 0.5em;
		
		color: #000000;
		font-size: 38px;
		font-weight: bold;
		margin: 1px;
		padding: 15px;
		width: 90%;
		
	}
		
</style>
</head>
<body background="imagenes/fondo1.png">
<div align="center">
	<div id="marco" align="center">
		<?=  $gloNombreAplicacion; ?>
	</div>
</div>
</body>
</html>
