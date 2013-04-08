<?php session_start();
 header("Cache-control: no-cache");
 
 require_once('../conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 
$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

?>

<html>
<head>
<title>Admin Modulos del Sistema</title>
<LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_admin.css"; ?>" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>
</head>
<body vlink="<?= $Color_Celda2; ?>" link="<?= $Color_Celda2; ?>">
<br><br>
<?php

$sql = "SELECT j0.* ";
$sql .=  " FROM srgc AS j0";
//$sql .=  " where activo = 'Y'";
$sql .=  " ORDER BY j0.idsoc";

$result = $conexionMysql->db->Execute($sql);
?>
	
	
	<table border="0" align="center" width="70%" style="border-collapse:inherit; border:inherit">
	<tr>
		<td width="6%" onClick="javascript:location.href='<?= "ad_new_sociedad.php?tipodato=1";?>';" ><img src="<? echo $gloRutaPublica . "/imagenes/nuevo.gif"; ?>" width="48" height="22" alt="Nuevo" style="cursor:pointer">		</td>
	</tr>
	</table>
	<table border="2" align="center" width="70%" style="border-collapse:collapse; border::inherit" class="tabla_s1">
	<tr>
		<td colspan="12" align="center" class= "tabla_s1_td_t1">
				<b>Sociedad</b>
		</td>
	</tr>
	<tr >
		<td width="4%" class = "tabla_s1_td_t1"></td>
		
		<td align="center" width="15%" class= "tabla_s1_td_t1">
			Id Sociedad		</td>
		<td align="center" class= "tabla_s1_td_t1">
			Nombre de la Sociedad		</td>
		<td align="center" class= "tabla_s1_td_t1">
			Id Integra		</td>
		<td align="center" width="10%" class= "tabla_s1_td_t1">
			Estado		</td>
		<td align="center" width="15%" class= "tabla_s1_td_t1">
			Fecmod		</td>
		
	</tr>
<?php
$reg = 0;
while($row=$result->FetchNextObj())
{	
$reg = $reg + 1;
?>
		<tr style="background:#FFFFFF; color:#333333" id="letra">
		
		<td align="center" onClick="javascript:location.href='<?= "ad_new_sociedad.php?cia=".$row->idsoc."&tipodato=2";?>'">
		<img src="<? echo $gloRutaPublica . "/imagenes/edit.png"; ?>" width="10" height="10" alt="Edit" style="cursor:pointer" title="Edit">		</td>
		
		<td align="center" class="tabla_s1_td_c1">
			<?= $row->idsoc; ?>
		</td>
		<td class="tabla_s1_td_c1">
			<?= $row->identificador; ?>
		</td>
		<td class="tabla_s1_td_c1" align="center">
			<?= $row->id_integra; ?>
		</td>
		<td class="tabla_s1_td_c1" align="center">
			<?php 
				if ($row->activo == 'Y')
				{
					echo "Activo";
				}
				else{
					echo "Inactivo";
				}
			?>
		</td>
		<td class="tabla_s1_td_c1">
			<?= $row->fecmod; ?>
		</td>
		
	</tr>
<?php 	
}
?>
	</table>
<br>
	<table align="center" border="0">
		<tr>
			<td width="70%" class="Tabla_Datos"><div align="center">
				<img src="<?php echo $gloRutaPublica . "/imagenes/printer.png"; ?>" width="32" height="32" name="print" border="0" style="filter:alpha(opacity=50); -moz-opacity:0.5" onMouseover="lightup(this, OPACITY_MOUSEOVER)" onMouseout="lightup(this, OPACITY_MOUSEOUT)"  onClick="javascript:retorna_imprime();" alt="<?=$listaMsgTrasv['7']; ?>">
											</div></td>
		</tr>
	</table>
<br>
<table border="0" align="center" width="20%">
	<tr>
		<td align="center" onClick="javascript:location.href='menu_izquierdo.php';" ><img src="<? echo $gloRutaPublica . "/imagenes/volver.png"; ?>" width="40" height="50" alt="Volver" style="cursor:pointer">
		</td>
	</tr>
</table>	

<?php
$conexionMysql->cerrar();
?>
</body>
</html>
