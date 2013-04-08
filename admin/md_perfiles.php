<?php session_start();
 header("Cache-control: no-cache");
 
 require_once('../conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 include ("../conexion/Conect_DB.php"); 
$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

?>

<html>
<head>
<title>Admin Modulos del Sistema</title>
<LINK href="<?php echo $gloRutaPublica . "/estilos/estilo_admin.css"; ?>" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>
</head>
<body>
<br><br>
<?php

$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
		mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());
	
		// maximo por pagina
		$limit = 10;
		// pagina pedida
		$pag = (int) $_GET["pag"];
		if ($pag < 1)
		{
		   $pag = 1;
		}
		$offset = ($pag-1) * $limit;

		$sql  = "SELECT SQL_CALC_FOUND_ROWS j0.idperfil, j0.desperfil, j0.obsperfil, j0.fecmod";
		$sql .= " FROM perfiles as j0";
		$sql .= " Order By j0.idperfil";		
		$sql .= " LIMIT $offset, $limit";
		//echo "<br>SQL: ".$sql;
		$sqlTotal = "SELECT FOUND_ROWS() as total";

		$rs = mysql_query($sql);
		$rsTotal = mysql_query($sqlTotal);

		$rowTotal = mysql_fetch_assoc($rsTotal);
		// Total de registros sin limit
		$total = $rowTotal["total"];

	
?>
	
	<table border="0" align="center" width="70%" style="border-collapse:inherit; border:inherit">
	<tr>
		<td width="6%" onClick="javascript:location.href='<?= "ad_new_perfiles.php?tipodato=1";?>';" ><img src="<? echo $gloRutaPublica . "/imagenes/nuevo.gif"; ?>" width="48" height="22" alt="Nuevo" style="cursor:pointer">		</td>
	</tr>
	</table>

	<table border="2" align="center" width="70%" style="border-collapse:collapse; border::inherit" class="tabla_s1">
	<?php
		if ($row = mysql_fetch_assoc($rs)){
	?>
	<tr>
		<td colspan="12" align="center" class= "tabla_s1_td_t1">
				<b>Perfiles</b>
		</td>
	</tr>
	<tr >
		<td width="4%" class = "tabla_s1_td_t1"></td>
		
		<td align="center" width="15%" class= "tabla_s1_td_t1">
			Id Perfil		</td>
		<td align="center" width="20%" class= "tabla_s1_td_t1">
			Perfil		</td>
		<td align="center"  class= "tabla_s1_td_t1">
			Obs. Perfil		</td>
		<td align="center" width="15%" class= "tabla_s1_td_t1">
			Fecmod		</td>
		
	</tr>
<?php
$reg = 0;
	do
	{
		$reg = $reg + 1;
?>
		<tr style="background:#FFFFFF; color:#333333" id="letra">
		
		<td align="center" onClick="javascript:location.href='<?= "ad_new_perfiles.php?per=".$row[idperfil]."&tipodato=2";?>'">
		<img src="<? echo $gloRutaPublica . "/imagenes/edit.png"; ?>" width="10" height="10" alt="Edit" style="cursor:pointer" title="Edit">		</td>
		
		<td align="center" class="tabla_s1_td_c1">
			<?= $row[idperfil]; ?>
		</td>
		<td class="tabla_s1_td_c1">
			<?= $row[desperfil]; ?>
		</td>
		<td align="center" class="tabla_s1_td_c1">
			<?= $row[obsperfil]; ?>
		</td>
		<td class="tabla_s1_td_c1">
			<?= $row[fecmod]; ?>
		</td>
		
	</tr>
<?php		
			} while($row = mysql_fetch_assoc($rs)); //while($row=$result->FetchNextObj());
		?>
			<tfoot>
		      <tr>
		         <td align="right" colspan="6">
		      <?php
		         $totalPag = ceil($total/$limit);
		         $links = array();
		         for( $i=1; $i<=$totalPag ; $i++)
		         {
		            $links[] = "<a href=\"?pag=$i\">$i</a>"; 
		         }
		         echo implode(" - ", $links);
		      ?>
		         </td>
		      </tr>
		   	</tfoot>
	<?php 
	} //fin del IF
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
