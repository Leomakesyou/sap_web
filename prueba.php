<?php
header("Cache-control: no-cache");
 require_once('conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 $ArchivoCalendar = "javascript/calendar_1.php";
 include ($ArchivoCalendar);

$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

?>
<html>
	<head>
		<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript">
			$(document).on("ready",funciones)
    
		    function funciones()
		    {
		    	var cont = 0;
		    	$("#q").focus();
		    	$("#q").on("keyup",Buscar);	
		    	/*$("select").on("dblclick",Traercliente);
		    	$("#nuevo_con").on("click",saludo);
		    	*/
		    }

			function desplegar_capa1(Lay)
			{

		 	Cab=eval(Lay.id)
		 	with (Cab.style) 
		 		if (display=="none")
		    		display="" 
		   		else 
		    		display="none" 
			}

			function Buscar(Lab)
		    {
		    	var list1 = "resultado"+Lab;

		    	Cab=eval(list1);
		    	
		    	var texto = $("#q"+Lab).val();
			 				 	
			 	if (texto.length >= 2)
		    	{

				 	with (Cab.style) 
				 		if (display=="none")
				    		display="" 
				   		 
				}
				else{
					with (Cab.style) 
						display="none"
				}
				//alert(texto);
		    }

		    function LlevarValor(valor, fila)
		    {
		    	alert(valor);
		    	alert(fila);
		    	$("#texto"+fila).val(valor);

		    }


		</script>
		<style type="text/css">
			.listaclientes{
				background-color: #DDD;
				width: 95%;
			}

		</style>
	</head>
<body>
	<table border="1" width="90%" >
		<tr>
			<td>
				#
			</td>
			<td>
				codigo
			</td>
			<td>
				nombre
			</td>
			<td>
				ocupacion
			</td>
		</tr>
	</table>
	<br/>
	<table border="3" align="center" width="70%" style="border-collapse:collapse" class="">
	<tr>
		<td colspan="8" align="center" class="titulo">
			<b><?= "Titulo ".$lang['txt_26']; ?></b>
		</td>
	</tr>
		
	<tr bgcolor="<?= $Color_Celda3; ?>" >
		<td align="center" width="30%" >
			<?= "Campo1 ". $lang['gen_est'];?>
		</td>
		<td align="center" width="40%">
			<?= "Campo2 ". $lang['gen_fec']; ?>
		</td>
		<td align="center" width="30%">
			<?= "Campo3 ".$lang['gen_usu']; ?>
		</td>
	</tr>
	<?php
	$fila = 0;
	while($fila < 4)
	{	//Muestra el Historico de la PQR Consultada
		$fila = $fila + 1;
	?>
		<font size="2" color="#FF0000">
		<tr id="letra" style="cursor:pointer" onClick="desplegar_capa1(<? echo "celda".$fila; ?>);"
		 onMouseOver="this.style.background='#FFFFCC'" onMouseOut = "this.style.background=''" 
		 bgcolor="<?= $Color_Celda1; ?>" bordercolor="<?= $Color_Celda1; ?>">
			<td width="30%" align="center" class="Tabla_SubTitulo" >
				<input type="text" name="cliente[]" id="<?= "texto".$fila; ?>" />
				<?= "dato1 ".$row_2->desestpqr; ?>
			</td>
			<td width="40%" align="center" class="Tabla_SubTitulo">
				<?= "dato2" . $row_2->fecmod; ?>
			</td>
			<td width="30%" align="center" class="Tabla_SubTitulo">
				<?= "dato3 ".$row_2->login; ?>
			</td>
		
		</tr>
		<tr id="<? echo "celda".$fila; ?>" style="display: none">
			<td align="center" colspan="6">
				<input type="text" id="<?= "q".$fila; ?>" name="q" onkeyup="Buscar(<?= $fila; ?>);" autofocus />
			    <select id="tipo">
			    	<option value="nomcli" selected>Nombre</option>
			    	<option value="nitcli" >Nit</option>
			    	<option value="idcliente" >Id Cliente</option>
			    </select>
			    <br/>
			    <div id="<?= "resultado".$fila; ?>" style="display:none">
			    	<select class="listaclientes" name="listbox" id="listaclientes<?= $fila; ?>" onchange="LlevarValor(this.value, <?= $fila; ?>);">
			    		<option value=""></option>
			    		<option value="1">cli_1</option>
			    		<option value="2">cli_2</option>
			    	</select>
			    </div>
			</td>
		</tr>

		
	<?php } //fin del while para mostrar el historico?> 	
		</font>
</table>

</body>
</html>