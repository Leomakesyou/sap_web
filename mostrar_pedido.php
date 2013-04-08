<?php session_start();
 require_once('conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 include ("conexion/Conect_DB.php");  

$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);
$identificador = $_POST['sociedad'];
if ($_POST[docentry]){
	$docentry = $_POST[docentry];
}
else{
	$docentry = $_GET[docentry];
}

if (isset($docentry) && $docentry != ''){
	
	$cont = 0;
	$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
	mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());
	mysql_query("SET NAMES 'utf8'");
	
	$sql  = "Select *, j0.docdate as docdate1, j2.name as rephslofsname, j3.name as unidadname, j4.name as operacionname, j5.name as quienllama1, j6.name as campo1, j7.descr as paracontoper1";
	$sql .= " From ordr as j0 ";
	$sql .= " Inner Join rdr1 as j1 on j0.docentry = j1.docentry";
	$sql .= " Left Join rephslofs as j2 on j0.rephslofs = j2.code ";
	$sql .= " Left Join unidad as j3 on j0.unidad = j3.code";
	$sql .= " Left Join operacion as j4 on j0.operacion = j4.code";
	$sql .= " Left Join quienllama as j5 on j0.quienllama = j5.code";
	$sql .= " Left Join ucampo as j6 on j0.campo = j6.code";
	$sql .= " Left Join contoper as j7 on j1.paracontoper = j7.fldvalue ";
	$sql .= " Where j0.docentry = '$docentry'";
	$sql .= " Order by j0.docentry, j1.linenum";

	//echo "<br>SQL: ".$sql;
	$result_pedido = mysql_query($sql,$link) or die(mysql_error());
	$row_pedido = mysql_fetch_assoc($result_pedido);
	$Total = $row_pedido[doctotal];
	
	$sql  = "Select campoextra1 from usuarios";
	$sql .= " Where login = '". $row_pedido[slpcode]."'";
	//echo "<br/>SQL:".$sql;
	$result = mysql_query($sql,$link) or die(mysql_error());
	$Habcampoextra1 = "";
	if ($row_c = mysql_fetch_assoc($result))
	{
		$Habcampoextra1 = $row_c[campoextra1];
	}

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mostrar Pedido</title>
	<link rel="stylesheet" href="estilos_sap.css" />
	<script src="jquery.js"></script>

	
	<script language="javascript">
		 $("#select").change(function () {
          var str = "";
          $("select option:selected").each(function () {
                id = $(this).value;
            	if (id == ''){
				$("#pedido").hide();
		   		return 0;		
				}
				else {
						$.post("frame_pedido.php", {id:id}, function(datos)
							{
						//El div que muestra los datos impresos en php tiene id="formatos"
							$("#pedido").html(datos);
						});
					//$("#pedido").slideDown(200);
					return 0;		
				}    
              });
        })

		 $(document).ready(function() {
			$(".botonExcel").click(function(event) {
				$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
				$("#FormularioExportacion").submit();
				});
			});

		function mostrarDiv(id) {
			
			var jsid = id;
		    if (id == ''){
				$("#pedido").hide();
		   		return 0;		
			}
			else {
					$.post("frame_pedido.php", {id:id}, function(datos)
						{
					//El div que muestra los datos impresos en php tiene id="formatos"
						$("#pedido").html(datos);
					});

				//$("#pedido").slideDown(200);
				return 0;		
			}
		}


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
		 		if (display=="none"){
		 			display="";

		 		}
		    	else{
		    		display="none";
		    	} 
		    		
			}

			function Buscar(Lab)
		    {
		    	var list1 = "resultado"+Lab;
		    	var res1 = Lab;
		    	Cab=eval(list1);
		    	var texto = $("#q"+Lab).val();
			 				 	
			 	if (texto.length >= 2 || texto == '*')
		    	{
		    		with (Cab.style) 
				 		if (display=="none")
				    		display=""; 

		    		//$("#resultado").show();
			    	var tipo = "";
				  	$("#tipo"+Lab+" option:selected").each(function () {
				    tipo = $(this).attr('value');
				 	 });
			    	//alert(tipo);
			    	$.post("buscar_item_div.php", {dato:texto,tipo:tipo,fila:res1}, function(datos)
					{
						//El div que muestra los datos impresos en php tiene id="formatos"
					$("#resultado"+res1).html(datos);
					});
				}
				else{
					with (Cab.style) 
						display="none";
				}
				//alert(texto);
		    }

		    function BuscarCliente(Lab)
		    {
		    	
		    	var list1 = "resultadoc";
		    	var res1 = Lab;
		    	Cab=eval(list1);
		    	var texto = $("#qc").val();

			 	if (texto.length >= 2 || texto == '*')
		    	{
		    		with (Cab.style) 
				 		if (display=="none")
				    		display=""; 

		    		if (texto == '*'){
		    			texto = "*";
		    		}
			    	var tipo = "";
				  	$("#tipoc option:selected").each(function () {
				    tipo = $(this).attr('value');
				 	 });
			    	//alert(tipo);
			    	$.post("buscar_cliente_div.php", {dato:texto,tipo:tipo,fila:res1}, function(datos)
					{
						//El div que muestra los datos impresos en php tiene id="formatos"
					$("#resultadoc").html(datos);
					});
					
				}
				else{
					with (Cab.style) 
						display="none";
				}
				//alert(texto);
		    }

		    function BuscarCli()
		    {
		    	
		    	var texto = "";
				var textoid = "";
				 $("#cardcode1 option:selected").each(function () {
				    texto = $(this).attr('value');
				    textoid = $(this).attr('id');
				 	 });
				$("#cardname").val(textoid);
			}

			function BuscarItem(fila)
			{
				var texto = "";
				var textoid = "";
				 $("#itemcode"+fila+" option:selected").each(function () {
				    texto = $(this).attr('value');
				    textoid = $(this).attr('id');
				 	 });
				
				var myString = String(textoid); 
				var myArray = textoid.split(';');
				
				$("#textoname"+fila).val("");
				$("#price"+fila).val("");
				$("#currency"+fila).val("");
				$("#quantity"+fila).val(0);
				$("#linetotal"+fila).val("");

				$("#textoname"+fila).val(myArray[0]);
				$("#price"+fila).val(myArray[1]);
				$("#currency"+fila).val(myArray[2]);
				$("#quantity"+fila).val(1);

				valor_total(fila);
				
			}

		    function validar(){
		    	
		    	if (document.form.cardcode.value == ''){
		    		alert("Es necesario que ingrese un Cliente");
		    		return false;
		    	}

		    	if (document.form.itemcode0.value == '')
		    	{
		    		alert("Es necesario que ingrese un Articulo");
		    		return false;
		    	}


		    	if (confirm("Esta Seguro(a) de continuar?"))
				{
					return true;
				}
				else
				{
					return false;
				} 

		    	return true;
		    }

		    function valor_total(linea){
		    	var cant   = $("#quantity"+linea).val();
		    	var precio = $("#price"+linea).val();
				var total = precio * cant;
		    	$("#linetotal"+linea).val(total);
		    }
	</script>

<script language="JavaScript" type="text/javascript">

window.addEvent('unload', PageLoad);
</script>

	<style>
	#cont_form label{
		font-family: "Helvetica";
		font-size: 20px;
		font-style: italic;
		margin: 2px;
		padding:2px;
	}
	#selector {
		background: #fef09e;
		border: solid 1px;
		margin: 2px;
		padding: 2px;
	}
	#selector option {
		font-family: verdana; 
		font-size: 18px; 
		color: black;
	}
	#label{
		background: #fff;
		font-family: Arial;
		font-size: 13px;
		margin: 1px;
		padding: 1px;
	}
	</style>

</head>
<body background="imagenes/fondo1.png">
	<?php
	if (isset($_SESSION["sudlogin"]))
	{
	?>

	<div id="cont_form">
	<form action="" method="post" name="form1" onsubmit="return validar()">
		<label>Sociedad <?php echo " : ".$row_pedido[identificador]; ?>
		</label>
			
	</form>
	</div>

	<?php
	}
	
	$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
	mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());
	$sql  = "SELECT * FROM ocrd Order by cardcode";
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$cliente[] = $row[cardcode];
		$namecliente[] = $row[cardname];
	}

	$sql  = "SELECT j0.itemcode, j0.itemname, j1.pricelist, j1.price, j1.currency 
			 FROM oitm as j0
			 Inner Join itm1 as j1 on j0.itemcode = j1.itemcode	";
	$sql .= " Order By j0.itemcode";
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$item[] = $row[itemcode];
		$nameitem[] = $row[itemname];
		$precio[] = $row[price];
		$moneda[] = $row[currency];
	}

	?>

	<?php
	$identificador = 1;
	
	if ($identificador <> ''){
		
		?>

		<div align="center" valign="middle">
			<form action="<?= $gloRutaPublica . "/exportar/ficheroExcel.php"; ?>" method="post" target="_blank" id="FormularioExportacion" 
				enctype=multipart/form-data >
				<font face="times" size="2" style="font-weight:bold;">Exportar</font><br/>
				<img src="<?php echo $gloRutaPublica . "/imagenes/excel.png"; ?>" width="30" height="30" alt="Excel" style="cursor:pointer" title="Excel" class="botonExcel" />
				<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
			</form>
		</div>
		
		<div id="pedido">
		<table width="100%">
			<tr>
				<td width="100%">
					<div id="Exportar_a_Excel">
					<table class="tabla_pedido">
						<tr>
							<td class="subtitulo">
							Orden de Venta 
							<font size="2">&nbsp; <b> ORDEN DE TRABAJO </b> &nbsp; &nbsp;</font>
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
							</td>
						</tr>
						<tr>
							<td>
							<!--form name="form" id="formulario" action="" method="post" onsubmit="return validar();"-->
								
								<!--  ++++++   CABECERA   +++++++   -->	
										<table>
											<tr>
												<td id="label1">
													Cliente
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[cardcode]; ?></label>
												</td>
												<td id="label1">
													Fecha de Contabilizaci&oacute;n:
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[docdate1]; ?></label>
												</td>
											</tr>
											
											<tr>
												<td id="label1">
													Nombre Cliente
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[cardname]; ?></label>
												</td>

												<td id="label1">
													Fecha de Entrega:
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[docduedate]; ?></label>
												</td>
											</tr>
											<tr>
												<td id="label1">
													Persona de contacto:
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[name]; ?></label>
												</td>
												<td id="label1">
													Fecha de Documento:
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[taxdate]; ?></label>
												</td>
											</tr>
											<tr>
												<td id="label1">
													N&uacute;mero de Referencia:
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[numatcard]; ?></label>
												</td>

												<td id="label1">
													Pozo:
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[pozo]; ?></label>
												</td>
											</tr>
											
											<tr>
												<td id="label1">
													Representante HSLOFS:
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[rephslofsname]; ?></label>
												</td>
												<td id="label1">
													Representante del Cliente:
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[repcliente]; ?></label>
												</td>
											</tr>

											<tr>
												<td id="label1">
													N&uacute;mero Tiquete F&iacute;sico:
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[tiquete_fisico]; ?></label>
												</td>
												<td id="label1">
													Quien Llama:
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[quienllama1]; ?></label>
													<br>
													Sugerido &nbsp;
													<label id="label"><?= $row_pedido[usugerido]; ?></label>
												</td>
											</tr>

											<tr>
												<td id="label1">
													Unidad
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[unidadname] ?></label>
												</td>
												<td id="label1">
													Operaci&oacute;n
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[operacionname] ?></label>
												</td>
											</tr>

											<tr>
												<td id="label1">
													Campo
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[campo1] ?></label>
												</td>
												
													
												</td>
											</tr>

											<tr>
												<td id="label1" colspan="2">
													Calidad &nbsp; <label id="label">
													<?php if($row_pedido[ucalidad] == 'S'){
														echo "Si";
													}
													else{
														echo "No";
													}
													?></label>
													 &nbsp;
													 Cumplimiento &nbsp; <label id="label">
													<?php if($row_pedido[ucumplimiento] == 'S'){
														echo "Si";
													}
													else{
														echo "No";
													}
													?></label>
													&nbsp;
													Ejecucion de Trabajo &nbsp; <label id="label">
													<?= $row_pedido[uejecucionw] ?></label>
												</td>
												<td id="label1" colspan="2">
													Equipo &nbsp; <label id="label">
													<?= $row_pedido[uequipo] ?></label>
													&nbsp;
													SISO &nbsp; <label id="label">
													<?= $row_pedido[usiso] ?></label>
													&nbsp;
													Medio Ambiente &nbsp; <label id="label">
													<?= $row_pedido[umedioa] ?></label>
												</td>
												
											</tr>

										</table>
								
								<br/>
								<div class="tabla_lineas">
										<table border=0 >
											<tr id="titulo_estatico">
												<td class="titulo_matriz" width="20px">
												#
												</td>
												<td class="titulo_matriz" width="150px">
													N&uacute;mero Art&iacute;culo
												</td>
												<td class="titulo_matriz" width="250px">
													Descripci&oacute;n de Art&iacute;culo
												</td>
												<td class="titulo_matriz" width="150px">
													Fecha Inicial
												</td>
												<td class="titulo_matriz" width="150px">
													Fecha Final
												</td>
												<td class="titulo_matriz" width="149px">
													No D&iacute;as
												</td>
												<td class="titulo_matriz" width="149px">
													Cantidad
												</td>
												<td class="titulo_matriz" width="149px">
													Precio unitario
												</td>
												<td class="titulo_matriz" width="150px">
													Total ML
												</td>
												<td class="titulo_matriz" width="150px">
													Proyecto
												</td>
												<td class="titulo_matriz" width="150px">
													Nombre Proyecto
												</td>
												<td class="titulo_matriz" width="150px">
													Conteo Operaciones
												</td>
												<td class="titulo_matriz" width="150px">
													Tipo de Operaci&oacute;n
												</td>
												<td class="titulo_matriz" width="150px">
													Pozo L&iacute;nea
												</td>
												<!--td class="titulo_matriz" width="150px">
													Indicador de Impuestos
												</td-->
												<!--td class="titulo_matriz" width="150px">
													No Orden Trabajo
												</td-->
												<td class="titulo_matriz" width="150px">
													Texto Libre
												</td>
												<td class="titulo_matriz" width="150px">
													Empleado 1
												</td>
												<td class="titulo_matriz" width="150px">
													% Empleado 1
												</td>
												<td class="titulo_matriz" width="150px">
													Alimentaci&oacute;n
												</td>
												<td class="titulo_matriz" width="150px">
													Empleado 2
												</td>
												<td class="titulo_matriz" width="150px">
													% Empleado 2
												</td>
												<td class="titulo_matriz" width="150px">
													Alimentaci&oacute;n Emp2
												</td>
												<td class="titulo_matriz" width="150px">
													Empleado 3
												</td>
												<td class="titulo_matriz" width="150px">
													% Empleado 3
												</td>
												<td class="titulo_matriz" width="150px">
													Alimentaci&oacute;n Emp3
												</td>
												<td class="titulo_matriz" width="150px">
													Empleado 4
												</td>
												<td class="titulo_matriz" width="150px">
													% Empleado 4
												</td>
												<td class="titulo_matriz" width="150px">
													Alimentaci&oacute;n Emp4
												</td>
												<td class="titulo_matriz" width="150px">
													Empleado 5
												</td>
												<td class="titulo_matriz" width="150px">
													% Empleado 5
												</td>
												<td class="titulo_matriz" width="150px">
													Alimentaci&oacute;n Emp5
												</td>
												<td class="titulo_matriz" width="150px">
													Empleado 6
												</td>
												<td class="titulo_matriz" width="150px">
													% Empleado 6
												</td>
												<td class="titulo_matriz" width="150px">
													Alimentaci&oacute;n Emp6
												</td>
												<td class="titulo_matriz" width="150px">
													Empleado 7
												</td>
												<td class="titulo_matriz" width="150px">
													% Empleado 7
												</td>
												<td class="titulo_matriz" width="150px">
													Alimentaci&oacute;n Emp7
												</td>
												<td class="titulo_matriz" width="150px">
													Empleado 8
												</td>
												<td class="titulo_matriz" width="150px">
													% Empleado 8
												</td>
												<td class="titulo_matriz" width="150px">
													Alimentaci&oacute;n Emp8
												</td>
												<td class="titulo_matriz" width="150px">
													Empleado 9
												</td>
												<td class="titulo_matriz" width="150px">
													% Empleado 9
												</td>
												<td class="titulo_matriz" width="150px">
													Alimentaci&oacute;n Emp9
												</td>
												<td class="titulo_matriz" width="150px">
													Empleado 10
												</td>
												<td class="titulo_matriz" width="150px">
													% Empleado 10
												</td>
												<td class="titulo_matriz" width="150px">
													Alimentaci&oacute;n Emp10
												</td>
												<td class="titulo_matriz" width="150px">
													% Descuento
												</td>
												<td class="titulo_matriz" width="150px">
													% Descuento Ecopetrol
												</td>
												<td class="titulo_matriz" width="150px">
													Detalle Servicio
												</td>
												<!--td class="titulo_matriz" width="150px">
													Detalles de Art&iacute;culo
												</td-->
												<!--td class="titulo_matriz" width="150px">
													No de L&iacute;nea
												</td-->
												<!--td class="titulo_matriz" width="150px">
													No Tiquete
												</td-->
												<!--td class="titulo_matriz" width="150px">
													Documento base
												</td-->
												<td class="titulo_matriz" width="150px">
													Adjuntos
												</td>
											</tr>

											<tr>
											<td colspan="100">
											<div class="tabla_detalle">
											<table border=0 >

											<?php
											$fila = 0;
											$comentarios = $row_pedido[comentarios];
											$doctotal = $row_pedido[doctotal];
											$doctotalext = $row_pedido[doctotalext];

											do
											{	
											?>
												
												<tr onMouseOver="this.style.background='#FFFFCC'" onMouseOut = "this.style.background=''" 
												 bgcolor="<?= $Color_Celda1; ?>" bordercolor="<?= $Color_Celda1; ?>">
													<td align="center" class="matriz_campo" style="width:20px;">
													<?= $row_pedido[linenum] + 1; ?>
													</td>
													<td class="matriz_campo" width="15%">
														<label id="label"><?= $row_pedido[itemcode] ?></label>
													</td>
													<td class="matriz_campo" style="width:255px;">
														<label id="label"><?= $row_pedido[dscription]?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[fechaini]?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[fechafin]?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[numdia]?></label> 	
													</td>
													<td class="matriz_campo">
														<label id="label"><?= $row_pedido[quantity] ?></label> 
													</td>
													<td class="matriz_campo">
														<label id="label"><?= $row_pedido[price] ?></label> 
													</td>
													<td class="matriz_campo">
														<label id="label"><?= $row_pedido[linetotal] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[project] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[prjname] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[paracontoper1] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[tipooperacion] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[pozolinea] ?></label> 
													</td>
													<!--td class="matriz_campo" >
														<label id="label"><?= $row_pedido[taxcode] ?></label> 
													</td-->
													<!--td class="matriz_campo" >
														<label id="label"><?= $row_pedido[ordentrabajo] ?></label> 
													</td-->
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[freetxt] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[empleado1] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[poremp1] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[aliemp1] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[empleado2] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[poremp2] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[aliemp2] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[empleado3] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[poremp3] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[aliemp3] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[empleado4] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[poremp4] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[aliemp4] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[empleado5] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[poremp5] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[aliemp5] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[empleado6] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[poremp6] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[aliemp6] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[empleado7] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[poremp7] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[aliemp7] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[empleado8] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[poremp8] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[aliemp8] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[empleado9] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[poremp9] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[aliemp9] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[empleado10] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[poremp10] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[aliemp10] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[discprcnt] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[porcdescecop] ?></label> 
													</td>
													<td class="matriz_campo" >
														<label id="label"><?= $row_pedido[dtllservicio] ?></label> 
													</td>
													<!--td class="matriz_campo" >
														<label id="label"><?= $row_pedido[text] ?></label> 
													</td-->
													
													<!--td class="matriz_campo" >
														<label id="label"><?= $row_pedido[linea] ?></label> 
													</td-->
													<!--td class="matriz_campo" >
														<label id="label"><?= $row_pedido[tiquete] ?></label> 
													</td-->
													<!--td class="matriz_campo" >
														<label id="label"><?= $row_pedido[docubase] ?></label> 
													</td-->
													<td class="matriz_campo" style="width:250px;">
														<?php
															if($row_pedido[anexo] == ''){}
															else{
														?>
														<img src="<?= $gloRutaPublica ."/imagenes/ver_archivo.jpg" ?>" alt="ver archivo"
														width="15" height="15" style="cursor:pointer" title="Ver" onClick="javascript:window.open('<?= $gloRutaPublica."/anexos/".$row_pedido[anexo]; ?>')" />
														<label id="label"><?= $row_pedido[anexo] ?></label> 
															<?php } ?>
													</td>
												</tr>

											<?php
											
											$fila = $fila + 1;
											 } while($row_pedido = mysql_fetch_assoc($result_pedido))
											?>
											</table>
											</div>
											</td>
											</tr>	
										</table>
										
										</div>
							</td>
						</tr>
						<tr>
							<td width="">
								Comentarios: &nbsp; &nbsp; &nbsp;
								<label id="label"><?= $comentarios; ?></label>
							</td>
						</tr>
						<tr>
							<td>
								Total Pedido: &nbsp; &nbsp; $  <?= number_format($doctotal, 0, ',', '.'); ?>
											&nbsp; &nbsp; &nbsp; USD <?= number_format($doctotalext, 0, ',', '.'); ?>
							</td>
						</tr>
						
						<tr>
							<td>
								<!--input class="boton_submit" type="submit" value="Crear" /-->
								&nbsp; &nbsp; &nbsp;
								<input class="boton_submit" type="button" value="Cancelar" onclick="javascript:location.href='<?= $_SERVER['HTTP_REFERER']; ?>';" />
							</td>
						</tr>
					<!--/form-->	
					</table>
					</div>
				</td>
			</tr>
		</table>
		<!-- Fin de la tabla -->
		
		</div>
	<?php	
	}
	?>
<!--  Tiquete Layout  -->
<table border="1" align="center" style="border-collapse:collapse;">
	<tr>
		<td align="center" valign="middle" onClick="javascript:location.href='<?= "tiquete_layout.php?id=".$docentry ?>';" >
			<img src="<? echo $gloRutaPublica . "/imagenes/find.gif"; ?>" width="20" height="20" alt="Layout" style="cursor:pointer">
		</td>
	</tr>
</table>
<!-- fin Tiquete layout -->
<br>
<table border="0" align="center">
	<tr>
		<td align="center" onClick="javascript:location.href='menu_izquierdo.php';" >
			<img src="<? echo $gloRutaPublica . "/imagenes/volver.png"; ?>" width="40" height="50" alt="Volver" style="cursor:pointer">
		</td>
	</tr>
</table>	


<?php 
include "extranet_pie.php";  ?>
</body>
</html>