<?
 header("Cache-control: no-cache");
 include $_SERVER[DOCUMENT_ROOT] . "/sudespensa/includes/conf.php";
 require ($gloIncludeAplicacion . "/extranet_chklogin.php");
 
?>
<html>
<head>
	<title><?php echo $gloNombreAplicacion . " " . $gloNombreCliente ?></title>
	<LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_extranet.css"; ?>" type=text/css rel=stylesheet>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<frameset cols="230,*" frameborder="NO" border="0" framespacing="0">
	<frame src="<?="menu_izquierdo.php" ?>" name="frameIzquierdo" scrolling="yes">
	<frame src="index.php" name="frameDerecho">
</frameset>
<noframes>
<body>
</body>
</noframes>
</html>
