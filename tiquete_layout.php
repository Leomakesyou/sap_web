<?php session_start();
 require_once('conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 include ("conexion/Conect_DB.php");  

$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);
$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());
//Tiquete de impresion 

$docentry = $_GET['id'];

$sql  = "Select *, j0.docdate as docdate1, j2.name as rephslofsname, j3.name as unidadname, j4.name as operacionname, j5.name as quienllama1, j6.name as campo1";
	$sql .= " From ordr as j0 ";
	$sql .= " Inner Join rdr1 as j1 on j0.docentry = j1.docentry";
	$sql .= " Left Join rephslofs as j2 on j0.rephslofs = j2.code ";
	$sql .= " Left Join unidad as j3 on j0.unidad = j3.code";
	$sql .= " Left Join operacion as j4 on j0.operacion = j4.code";
	$sql .= " Left Join quienllama as j5 on j0.quienllama = j5.code";
	$sql .= " Left Join ucampo as j6 on j0.campo = j6.code";
	$sql .= " Where j0.docentry = '$docentry'";
	$sql .= " Order by j0.docentry, j1.linenum";

$result_pedido = mysql_query($sql,$link) or die(mysql_error());
$row_pedido = mysql_fetch_assoc($result_pedido);
$Total = $row_pedido[doctotal];
$Totalext = $row_pedido[doctotalext];

$rephslofs = $row_pedido[rephslofsname];
$repcliente = $row_pedido[repcliente];

?>
<script src="jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
		});
	});
	
	function retorna_imprime() 
	{
		window.print();
	}

</script>
<style type="text/css">
	#cab1_cuadro{
		border: 1px solid;
		font-family: Arial, Verdana;
		font-size: 10px;
		font-weight: bold;
		margin: 2px 2px 0px 10px;
		padding: 2px;
		width: auto;
	}

	#cab2_cuadro{
		border: 1px solid;
		font-family: Arial, Verdana;
		font-size: 10px;
		margin: 1px;
		padding: 1px;
	}
	#cab2_tr{
		font-weight: bold;
		margin: 1px;
		padding: 9px;
	}
	#cab3_tabla{
		border: 1px solid;
		border-collapse: collapse;
		margin: 1px;
		padding: 1px;
	}
	#cab3_titulo{
		font-family: Arial, verdana;
		font-size: 10px;
		font-weight: bold;
	}
	#cab3_linea{
		font-family: Arial, verdana;
		font-size: 9px;
	}
	#cab4_tabla{
		border: 1px solid;
		border-collapse: collapse;
		margin: 1px;
		padding: 1px;
	}
	#cab4_titulo{
		font-family: Arial, verdana;
		font-size: 10px;
		font-weight: bold;
	}
	#cab4_cuadro{
		height: 70px;
		padding: 1px;
	}
	#cab5_tabla{
		border: 1px solid;
		border-collapse: collapse;
		margin: 1px;
		padding: 1px;
	}
	#cab5_cuadro{
		font-family: Arial, verdana;
		font-size: 10px;
		font-weight: bold;
		height: 60px;
		padding: 1px;
	}
	#cab6_tabla{
		border: 1px solid;
		border-collapse: collapse;
		margin: 1px;
		padding: 1px;
	}
	#cab6_cuadro{
		font-family: Arial, verdana;
		font-size: 10px;
		font-weight: bold;
		height: 60px;
		padding: 1px;
	}
	
</style>

<div align="center" valign="middle">
	<table>
		<tr>
			<td width="70%" class="Tabla_Datos">
				<?php 
					if($row_pedido[docusap] == 0)
					{ 
					}
					else{
						?>
						<div align="center">
						<img src="<?php echo $gloRutaPublica . "/imagenes/printer.png"; ?>" width="32" height="32" name="print" 
						border="0" style="filter:alpha(opacity=50); -moz-opacity:0.5"  onClick="javascript:retorna_imprime();" alt="imprimir">
						</div>		
						<?php 
					}
				?>
				
			</td>
		</tr>
	</table>
</div>


<div id="Exportar_a_Excel">
<table align="center" border="0" id="tabla_tiquete" width="95%">
	
	<tr>
		<td> 
			<table width="100%">
				<tr>
					<td width="20%">
						<img src="imagenes/logo_empresa.png" >
					</td>
					<td valign="bottom" width="80%" >
						<div id="cab1_cuadro">
						&nbsp;<b>  ORDEN DE TRABAJO </b> &nbsp; &nbsp; &nbsp;
						<?php 
						if($row_pedido[docusap] == 0)
						{
							echo "<font color=red />SIN DATO</font>";
						}
						else{
							echo "".$row_pedido[docusap];
						}
						?>

						&nbsp; &nbsp; &nbsp;
						<?php 
						if($row_pedido[canceled] == 'Y')
						{
							echo "<font color=red size=5 />CANCELADO</font>";
						}
						else{
							//echo "".$row_pedido[docusap];
						}	
						?>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td> 
			
			<table id="cab2_cuadro" width="100%">
				<tr id="cab2_tr">
					<td width="10%">
						CLIENTE: 
					</td>
					<td width="22%"><?= $row_pedido[cardname] ?></td>
					<td width="10%">
						FECHA:
					</td>
					<td width="22%"><?= $row_pedido[docdate1] ?></td>
					<td width="10%">
						CONTRATO:
					</td>
					<td width="22%"><?= $row_pedido[numatcard] ?></td>
				</tr>
				<tr id="cab2_tr">
					<td>
						CAMPO: 
					</td>
					<td width="22%"><?= $row_pedido[campo1] ?></td>
					<td>
						OPERACION:
					</td>
					<td width="22%"><?= $row_pedido[operacionname] ?></td>
					<td>
						QUIEN LLAMA:
					</td>
					<td width="22%"><?= $row_pedido[quienllama1]; ?></td>
				</tr>
				<tr id="cab2_tr">
					<td>
						POZO: 
					</td>
					<td width="22%"><?= $row_pedido[pozo] ?></td>
					<td>
						UNIDAD/SET:
					</td>
					<td width="22%"><?= $row_pedido[unidadname] ?></td>
					<td>
					</td>
					<td width="22%"></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td> 
			<table border="1" width="100%" id="cab3_tabla">
				<tr>
					<td id="cab3_titulo">
						DESCRIPCION SERVICIO
					</td>
					<td id="cab3_titulo">
						INICIA
					</td>
					<td id="cab3_titulo">
						TERMINA
					</td>
					<td id="cab3_titulo">
						POZO
					</td>
					<td id="cab3_titulo">
						CANT.
					</td>
					<td id="cab3_titulo">
						DETALLE SERVICIO
					</td>
					<td id="cab3_titulo">
						% Des
					</td>
					<td id="cab3_titulo">
						COSTO UNITARIO
					</td>
					<td id="cab3_titulo">
						COSTO TOTAL
					</td>
				</tr>
				<!-- Ciclo -->
				<?php 
				$comentarios = $row_pedido[comentarios];
				do{
				?>
				<tr>
					<td id="cab3_linea">
						<?= $row_pedido[dscription] ?>
					</td>
					<td align="center" id="cab3_linea">
						<?= substr($row_pedido[fechaini], 0, 10) ?>
					</td>
					<td align="center" id="cab3_linea">
						<?= substr($row_pedido[fechafin], 0, 10) ?>
					</td>
					<td align="center" id="cab3_linea">
						<?= $row_pedido[pozolinea] ?>
					</td>
					<td align="right" id="cab3_linea">
						<?= $row_pedido[quantity] ?>
					</td>
					<td id="cab3_linea">
						<?= $row_pedido[dtllservicio] ?>
					</td>
					<td align="center" id="cab3_linea">
						
					</td>
					<td align="right" id="cab3_linea">
						<?= number_format($row_pedido[price], 2, ',', '.'); ?>
					</td>
					<td align="right" id="cab3_linea">
						<?= number_format($row_pedido[linetotal], 0, ',', '.'); ?>
					</td>
				</tr>
				<?php
				 } while($row_pedido = mysql_fetch_assoc($result_pedido))
				?>
				<!-- fin ciclo -->

				<tr>
					<td colspan="6"></td>
					<td colspan="2" id="cab3_titulo">
					TOTAL Sin IVA
					</td>
					<td id="cab3_linea" align="right">
						<b> $	<?= number_format($Total, 0, ',', '.'); ?> </b>
					</td>
				</tr>
				<tr>
					<td colspan="6"></td>
					<td colspan="2" id="cab3_titulo">
					TOTAL Sin IVA
					</td>
					<td id="cab3_linea" align="right">
						<b> USD	<?= number_format($Totalext, 0, ',', '.'); ?> </b>
					</td>
				</tr>

			</table>
		</td>
	</tr>

	<!--tr>
		<td> 
			<table border="1" id="cab4_tabla" width="100%">
				<tr>
					<td id="cab4_titulo" width="20%">
						FECHA
					</td>
					<td id="cab4_titulo" width="80%">
						DESCRIPCION DE OPERACION
					</td>
				</tr>
				<tr>
					<td colspan="2" id="cab4_cuadro" width="20%">

					</td>
				</tr>
			</table>
		</td>
	</tr-->

	<tr>
		<td> 
			<table border="1" id="cab5_tabla" width="100%">
				<tr>
					<td id="cab5_cuadro" valign="top">
						OBSERVACIONES: &nbsp;<br>
						<?= $comentarios ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td> 
			<table border="1" id="cab6_tabla" width="100%">
				<tr>
					<td align="center" id="cab6_cuadro" valign="top" width="33%">
						REPRESENTANTE HSLOFS
						<br><br><br>
						<?= $rephslofs ?>
					</td>
					<td align="center" id="cab6_cuadro" valign="top" width="33%">
						Vo Bo CLIENTE
						<br><br><br>
					</td>
					<td align="center" id="cab6_cuadro" valign="top" width="33%">
						REPRESENTANTE DEL CLIENTE
						<br><br><br>
						<?= $repcliente ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>



<input class="boton_submit" type="button" value="<< Regresar" onclick="javascript:location.href='<?= $_SERVER['HTTP_REFERER']; ?>';" />

