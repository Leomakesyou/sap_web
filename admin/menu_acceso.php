<? session_start();
 header("Cache-control: no-cache");
require_once('../conexion/conf.php');
// require ($gloIncludeAplicacion . "/extranet_chklogin.php");
if (!isset($_SESSION['sudlogin']) or $_SESSION['sudlogin'] == '')
{
	?>
	<script>
		window.location.replace("<?= $gloRutaPublica ?>");
		r = alert('Sesion No Iniciada.');
	</script>
	<?php
}
else
{
?>
<html>
<head>
<title><?php echo ".: Administraci&oacute;n  :."; ?></title>
<LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_extranet.css"; ?>" type=text/css rel=stylesheet>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
<!--
 window.moveTo(0,0);
 if (document.all) {
  top.window.resizeTo(screen.availWidth,screen.availHeight);
 }
 else if (document.layers||document.getElementById) {
  if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
   top.window.outerHeight = screen.availHeight;
   top.window.outerWidth = screen.availWidth;
  }
 }
//-->
</script>
</head>
<frameset rows="12%,*" frameborder="1" border="1" framespacing="0">
			<frame src="frame_superior.php" name="frameSuperior" scrolling="NO" noresize>
			<!--frameset cols="20%,*" frameborder="1" border="1" framespacing="0"-->
			<frame src="menu_izquierdo.php" name="frameInferior" scrolling="yes">
				<!--frame name="contenido" scrolling="yes"-->
			<!--/frameset-->
</frameset>
<noframes><body>
</body></noframes>
</html>
<?php } ?>