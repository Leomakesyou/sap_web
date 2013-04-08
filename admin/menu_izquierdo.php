<?php session_start();
 header("Cache-control: no-cache");
 require_once('../conexion/conf.php');

 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 
$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

$idperfil = $_SESSION['sudperfil'];
$nombres = $_SESSION['sudnombre'];
$nomperfil = $_SESSION['suddesperfil'];


?>
<html>
	<head>
		<meta charset="utf-8" />
		<link href="<?php echo $gloRutaPublica . "/estilos/estilo_admin.css"; ?>" type=text/css rel=stylesheet>
		<script language="JavaScript" src="<?= $gloRutaPublica . "/javascript/Utilities.js" ?>"></SCRIPT>
		<title>Menu </title>
		<script src="jquery.js"></script>
		<script language="javascript">
			
		function openwindow(url){ 
		 window.open(url, 'chat54057', 'width=572,height=320,menubar=no,scrollbars=1,resizable=1');
		}

		function Click_Boton(ruta)
		{
			alert("La ruta: "+ruta);
			parent.contenido.location.href=ruta;
			return false;
		}
		</script>
<style type="text/css">
@font-face
			{
				font-family: "letra1";
				src: url("Mothproof_Script-webfont.eot");
				src: url("Mothproof_Script-webfont.eot?#solotexto") format("embedded-opentype"),
					 url("Mothproof_Script-webfont.woff") format("woff"),
					 url("Mothproof_Script-webfont.ttf") format("truetype"),
					 url("Mothproof_Script-webfont.svg#webfontgfA0eZ2f") format("svg");
			}
h1{
	font-family: "letra1", Arial;
	font-size: 2.2em;
	margin:2px;
	padding: 2px;
}
h2{
	font-family: Arial;
	font-size: 1.7em;
	margin:2px;
	padding: 2px;	
}

</style>
</head>

<body vlink="#000066" background="imagenes/fondo1.png">

<h1 align=left><strong>
Administraci&oacute;n SAP WEB 
</strong>
</h1>
<h2 align=left>
	<font style="font-style:italic">Modulo de Administraci&oacute;n </font><br/>
	<?php echo $nombres;  ?> 	
	<br/>
	Perfil: &nbsp;
	<?= $nomperfil; ?>
</h2>
<p align="left">
<div align=left id="menu2" class="menu2">
	&nbsp; &nbsp; <strong>men&uacute; de administrador</strong>
		<ul align=center class="menu">
		<?php
		///INICIO DEL CUERPO DEL MENU ***************
		$sql = "SELECT j0.idmodulo, j0.desmodulo, j0.ruta";
		$sql .= " FROM menu_admin as j0 ";
		//echo "sql: ".$sql;	
		
		$result = $conexionMysql->db->Execute($sql);
		
		while ($row=$result->FetchNextObj())
		{ 
		?>
			<li align="left">
				<a id="<?= $row->ruta ?>" target="_self" href="app" onClick="javascript:location.href='<?= $row->ruta ?>'
				 return false" >
 				<?php echo $row->desmodulo; ?>
				</a> 
				<!-- <a id="<?= $row->ruta ?>" target="_self" href="app" onClick="javascript:parent.contenido.location.href='<?= $row->ruta ?>'
				 return false" >
 				<?php echo $row->desmodulo; ?>
				</a>  -->
			</li>
		<?php
		}//<?= $gloRutaPublica . "/close_sesion" . ".php" 
		?>
			
		</ul>
</div>
</p>
<table style="margin:1em; border-style:solid;border-color: #00CC00;">
<tr>
<td background="" align="center" style="cursor:pointer" onMouseOver="this.style.background='#00CC33';color='#FF0000'" 
								onMouseOut = "this.style.background=''" onClick="exit2('¿ esta seguro(a) que desea salir ?')">
							 <font size="2" face="Georgia, Times New Roman, Times, serif" color="#000066">
							 <b><?php echo "Salida Segura"; ?>
							</b>
							</font>
							</td>
						</tr>
	</table>
</body>
</html>
<?php $conexionMysql->cerrar(); ?>