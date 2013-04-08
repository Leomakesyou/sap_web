<?php session_start();
 header("Cache-control: no-cache");
 require_once('conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 
$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

$sql  = " Select j0.nombre, j1.desperfil from usuarios as j0";
$sql .= " Inner Join perfiles as j1 on j0.idperfil = j1.idperfil";
$sql .= " Where j0.login = '" . $_SESSION["sudlogin"] . "'";

$result = $conexionMysql->db->Execute($sql);
$row=$result->FetchNextObj();

$idperfil = $_SESSION['sudperfil'];
$nombres = $row->nombre;
$nomperfil = $row->desperfil;

?>
<html>
	<head>
		<meta charset="utf-8" />
		<link href="<?php echo $gloRutaPublica . "/estilos/estilo_sistema.css"; ?>" type=text/css rel=stylesheet>
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
		function desplegar_capa(Lay)
		{
			
			Cab = eval(Lay.id)
			with (Cab.style)
				if (display == "none")
					display = ""
				else
					display = "none"

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
/*
#opcion_menu {  
	padding: 1px;
	text-decoration: none;
	color: white;
	font-size:14px;
	font-weight: bold;
	text-shadow: 0 1px 0 black;
	line-height: 35px;
	width: 150px auto;
	border-right: 25px solid transparent;
	border-bottom: 25px solid #4c4c4c; 
	height: 0;
	display: inline-block;
}
*/ 
</style>
</head>

<body vlink="#000066" background="imagenes/fondo1.png">

<h1 align=left><strong>
<!--img src="<?= $gloRutaPublica . "/imagenes/logo_1.png" ?>" width="80%"-->
<?= $gloNombreAplicacion ?>
</strong>
</h1>
<h2 align=left>
	<font style="font-style:italic">Bienvenido </font><br/>
	<?php echo $nombres;  ?> 	
	<br/>
	Perfil: &nbsp;
	<?= $nomperfil; ?>
</h2>
<p align="left">
<div align=left id="menu2" class="menu2">
	&nbsp; &nbsp; <strong>men&uacute; de usuario</strong>
		<ul align=center class="menu">
		<?php
		//echo "Inicio: ";	
		///INICIO DEL CUERPO DEL MENU ***************
		$sql = "SELECT DISTINCT j3.desperfil, j0.idmodulo, j0.desmodulo FROM menu_modulos as j0";
		$sql .= " Inner join menu_aplicaciones as j1 on j0.idmodulo = j1.idmodulo";
		$sql .= " Inner join menu_aplicacionesxperfil as j2 on j1.idaplicacion = j2.idaplicacion";
		$sql .= " inner join perfiles as j3 on j2.idperfil = j3.idperfil";
		$sql .= " WHERE j3.idperfil = '$idperfil' ";
		$sql .= " Order By j0.idmodulo";
		//echo "sql: ".$sql;	
		
		$result = $conexionMysql->db->Execute($sql);
		
		while ($row_modelo = $result->FetchNextObj())
		{ 
			$fila = $row_modelo->idmodulo;
		?>
			<!--li align="left" -->
				<a id="opcion_menu" onClick="desplegar_capa(<?= "celda".$fila; ?>);"  >
 				<?php echo $row_modelo->desmodulo; ?>
				</a> 
			<!--/li-->
			<?php
			
			$sql = "SELECT j0.idaplicacion, j1.desaplicacion, j1.ruta, j0.idperfil, j2.desperfil, j1.idmodulo, j3.desmodulo";
			$sql .= " FROM menu_aplicacionesxperfil as j0 ";
			$sql .= " Inner Join menu_aplicaciones as j1 on j0.idaplicacion = j1.idaplicacion";
			$sql .= " Inner Join perfiles as j2 on j0.idperfil = j2.idperfil";
			$sql .= " Inner Join menu_modulos as j3 on j1.idmodulo = j3.idmodulo";
			$sql .= " WHERE j0.idperfil = '$idperfil' and j1.idmodulo = '$row_modelo->idmodulo'  ";
			$sql .= " Order By j0.idaplicacion";
			//echo "sql: ".$sql;	
			
			$result_1 = $conexionMysql->db->Execute($sql);
			
			?>
			<div id="<?= "celda".$fila; ?>" style="display:none">
				<?php
				while ($row = $result_1->FetchNextObj())
				{ 
				?>
					<!--li align="left" -->
						<a class="opcion_submenu" id="<?= $row->ruta ?>" target="_self" href="<?= $row->ruta; ?>" 
							onClick="javascript:location.href='<?= $row->ruta ?>' return false" >
		 				<?php echo $row->desaplicacion; ?>
						</a> 
					<!--/li-->
				<?php
				}//<?= $gloRutaPublica . "/close_sesion" . ".php" 
			?>
			</div>
		<?php
		}//<?= $gloRutaPublica . "/close_sesion" . ".php" 
		
		?>
		<div class="menu3">
		<li align="left">
				<a id="cclave" target="_self" href="app" onClick="javascript:location.href='ad_cclave_usu.php?login=<?= $_SESSION[sudlogin] ?>&page=menu_izquierdo.php'
				 return false" >
 				Cambio de Clave
				</a> 
			</li>
		</div>

		</ul>
</div>

</p>

	<table style="margin:1em; border-style:solid;border-color: #00CC00;">
		<tr>
			<td background="" align="center" style="cursor:pointer" onMouseOver="this.style.background='#00CC33';color='#FF0000'" 
								onMouseOut = "this.style.background=''" onClick="exit2('¿ esta seguro(a) que desea salir ?')">
				<font size="2" face="Georgia, Times New Roman, Times, serif" color="#000066">
					<b><?php echo "Salida Segura"; ?></b>
				</font>
			</td>
		</tr>
	</table>
</body>
</html>
<?php $conexionMysql->cerrar(); ?>