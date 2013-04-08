<?php session_start();
 require_once('conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 include ("conexion/Conect_DB.php");

$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);
$identificador = $_POST['sociedad'];


if (isset($_POST[cardcode])){
	
	$identificador = $_POST[identificador];
	$cont = 0;
	$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
	mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());
	
	$fecha = date("Ymd");
	$hora  = date("His");

	$sql  = "Select ifnull(max(docentry) + 1,1) as consec from ordr";
	$result = mysql_query($sql,$link) or die(mysql_error());
	
	if ($row = mysql_fetch_assoc($result))
	{
		$docentry = $row[consec];
	}
	else{
		$docentry = 1;
	}

	$doctotal = 0;

	$sql  = "Select campoextra1 from usuarios";
	$sql .= " Where login = '". $_SESSION[sudlogin]."'";

	$result = mysql_query($sql,$link) or die(mysql_error());
	$Habcampoextra1 = "";
	if ($row_c = mysql_fetch_assoc($result))
	{
		$Habcampoextra1 = $row_c[campoextra1];
	}

	foreach($_POST[itemcode] as $key => $value){
		//echo "<br>Item: ".$_POST[itemcode][$key]." ; Precio: ".$_POST[price][$key];
		if ($_POST[itemcode][$key] != '')
		{
			$item 	= "";
			$item 	= $_POST[itemcode][$key];
			
			$sql  = "Select itemname from oitm";
			$sql .= " Where itemcode = '$item' and identificador = '$identificador'";
			$result_p = mysql_query($sql,$link) or die(mysql_error());
			$row_p = mysql_fetch_assoc($result_p);
			$dscription	= "";
			$dscription	= $row_p[itemname];
			//$dscription	= $_POST[itemname][$key];
			$cant	= "";
			$cant	= $_POST[quantity][$key];
			$moneda = "$";
			//$moneda = $_POST[currency][$key];
			$precio	= "";
			$precio	= $_POST[price][$key];
			$total	= "";
			$total 	= $_POST[linetotal][$key];
			$user	= "";
			$user	= $_SESSION["sudlogin"];
			$doctotal = $doctotal + $total;
			$campoextra1 = 0;
			$comision = 0;
			//echo "<br/>Habcampoextra: ".$Habcampoextra1;
			if ($Habcampoextra1 == 'Y')
			{
				$campoextra1 = $_POST[campoextra1][$key];	
				$comision = ($precio - $campoextra1) * $cant;
				//echo "<br/>campoextra1: ".$campoextra1." ;; Comision: ".$comision;
			}
			
			$sql  = "Insert Into rdr1 (docentry, linenum, itemcode, dscription, quantity";
			$sql .= ", price, linetotal, slpcode, docdate, hora, currency, identificador, precioventa, comision)";
			$sql .= " Values('$docentry','$key', '$item', '$dscription', '$cant'";
			$sql .= ", '$precio', '$total', '$user', '$fecha', '$hora', '$moneda', '$identificador', '$campoextra1', '$comision')";
			//$result = $conexionMysql->db->Execute($sql);
			$result = mysql_query($sql,$link) or die(mysql_error());
			//echo "<br>SQL: ".$sql;	
		}
		$cont++;
	}

	$docnum 	= "";
	$doctype 	= "";
	$docstatus 	= "";
	$docdate 	= $fecha;
	$docduedate = $fecha;
	$cardcode	= $_POST[cardcode];
	$cardname	= $_POST[cardname];
	$docrate	= "";
	$groupnum	= "";
	$slpname	= $_SESSION["sudlogin"];
	$usersign	= $_SESSION["sudlogin"];
	$comentario = $_POST[comentario];

	$sql  = "Insert Into ordr (docentry, docnum, doctype, docstatus, docdate, docduedate, cardcode";
	$sql .= ", cardname, docrate, doctotal, groupnum, slpcode, usersign, hora, identificador, comentario)";
	$sql .= " Values('$docentry','$docnum', '$doctype', '$docstatus', '$docdate', '$docduedate', '$cardcode'";
	$sql .= ", '$cardname', '$docrate', '$doctotal', '$groupnum', '$slpname', '$usersign', '$hora', '$identificador', '$comentario' )";
	//echo "<br>SQL: ".$sql;
	//$result = $conexionMysql->db->Execute($sql);
	$result = mysql_query($sql,$link) or die(mysql_error());

//	echo "<br>sql:".$sql;

	$sql  = "Select * From ordr as j0 ";
	$sql .= " Inner Join rdr1 as j1 on j0.docentry = j1.docentry";
	$sql .= " Where j0.docentry = '$docentry'";
	$sql .= " Order by j0.docentry, j1.linenum";
	//echo "<br>SQL: ".$sql;
	$result_pedido = mysql_query($sql,$link) or die(mysql_error());

	
	if ($row_pedido = mysql_fetch_assoc($result_pedido))
	{
		echo "<h1>Referencia del pedido: ".$docentry."</h1>";
		echo "<h2>Se ha registrado un pedido para el Cliente: ".$cardname."</h2>";
		echo "<h3>El total del pedido es: $ ".number_format($doctotal, 0, ',', '.')."</h3>";		
		$Total = $row_pedido[doctotal];
		//****************************   EXPORTAR A EXCEL   ************************
		?>
		<link rel="stylesheet" href="estilos_sap.css" />
		<script src="jquery.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
			$(".botonExcel").click(function(event) {
				$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
				$("#FormularioExportacion").submit();
				});
			});
		</script>
		<style type="text/css">
			#label{
				background: #fff;
				font-family: Arial;
				font-size: 13px;
				margin: 1px;
				padding: 1px;
			}
		</style>
				<div align="center" valign="middle">
					<form action="<?= $gloRutaPublica . "/exportar/ficheroExcel.php"; ?>" method="post" target="_blank" id="FormularioExportacion" >
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
									Orden de Venta &nbsp; &nbsp; <?= $row_pedido[identificador]; ?>
									&nbsp; &nbsp; Referencia: <?= $docentry; ?>
									</td>
								</tr>
								<tr>
									<td>
									<!--form name="form" id="formulario" action="" method="post" onsubmit="return validar();"-->
										
										<table>
											<tr>
												<td id="label1">
													Cliente
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[cardcode]; ?></label>
												</td>
											</tr>
											<tr>
												<td id="label1">
													Nombre
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[cardname]; ?></label>
												</td>
											</tr>
											<tr>
												<td id="label1">
													Comentario:
												</td>
												<td id="campo1">
													<label id="label"><?= $row_pedido[comentario]; ?></label> 
												</td>
											</tr>

										</table>
										
										<br/>
										<div class="tabla_detalle">
										
										<table border=1 width="100%">
											<tr>
												<td class="titulo_matriz">
												#
												</td>
												<td class="titulo_matriz" >
													N&uacute;mero Art&iacute;culo
												</td>
												<td class="titulo_matriz" >
													Descripci&oacute;n de Art&iacute;culo
												</td>
												<td class="titulo_matriz" >
													Cantidad
												</td>
												<!--td class="titulo_matriz" >
													Moneda
												</td-->
												<td class="titulo_matriz" >
													Precio unitario
												</td>

												<?php
												if ($Habcampoextra1 == 'Y')
												{  ?>
													<td class="titulo_matriz" >
														Precio Vendedor
													</td>	
													<td class="titulo_matriz" >
														Comision
													</td>	
												<?php
												}
												?>

												<td class="titulo_matriz" >
													Total
												</td>
											</tr>

											<?php
											$fila = 0;
											do
											{	
											?>
												
												<tr onMouseOver="this.style.background='#FFFFCC'" onMouseOut = "this.style.background=''" 
												 bgcolor="<?= $Color_Celda1; ?>" bordercolor="<?= $Color_Celda1; ?>">
												<td align="center" class="matriz_campo">
												<?= $row_pedido[linenum] + 1; ?>
												</td>
												<td class="matriz_campo" width="15%">
													<label id="label"><?= $row_pedido[itemcode] ?></label>
												</td>
												<td class="matriz_campo">
													<label id="label"><?= $row_pedido[dscription]?></label> 
												</td>
												<td class="matriz_campo">
													<label id="label"><?= $row_pedido[quantity] ?></label> 
												</td>
												<!--td class="matriz_campo">
													
												</td-->
												<input type="hidden" name="currency[]" size="2" value="<?= $row_pedido[currency] ?>" readonly/>
												<td class="matriz_campo">
													<label id="label"><?= $row_pedido[price] ?></label> 
												</td>
												<?php
												if ($Habcampoextra1 == 'Y')
												{  ?>
													<td class="matriz_campo">
														<label id="label"><?= $row_pedido[precioventa] ?></label> 
													</td>
													<td class="matriz_campo">
														<label id="label"><?= $row_pedido[comision] ?></label>
													</td>
												<?php 
												}
												?>
												<td class="matriz_campo">
													<label id="label"><?= $row_pedido[linetotal] ?></label> 
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
								<tr>
									<td>
										Total Pedido: &nbsp; &nbsp; <?= number_format($Total, 0, ',', '.'); ?>
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

	<?php

	}
	else{
		echo "<br><h1>No ha sido posible ingresar el pedido, intente de nuevo. ";
		echo "<br> Si el problema persiste comuniquese con el administrador.</h1>";
	}

?>
	<table border="0" align="center">
		<tr>
			<td align="center" onClick="javascript:location.href='<?= $_SERVER['HTTP_REFERER']; ?>';" ><img src="<? echo $gloRutaPublica . "/imagenes/volver.gif"; ?>" width="40" height="50" alt="Volver" style="cursor:pointer">
			</td>
		</tr>
	</table>	

<?php

	$conexionMysql->cerrar();
exit();

}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Ingresar Pedido</title>
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

		    function BuscarCli(opcion)
		    {
		    	
		    	var texto = "";
				var textoid = "";
				if (opcion == 1)
				{
					$("#cardcode1 option:selected").each(function () {
				    texto = $(this).attr('value');
				    textoid = $(this).attr('id');
				 	 });
					$("#cardname1").val(texto);

				}
				if (opcion == 2)
				{
					$("#cardname1 option:selected").each(function () {
				    texto = $(this).attr('value');
				    textoid = $(this).attr('id');
				 	 });
					$("#cardcode1").val(texto);
				}
				
				
				$("#cardname").val(textoid);
			}

			function BuscarItem(fila, opcion)
			{
				var texto = "";
				var textoid = "";
				
				if (opcion == 1)
				{
					$("#itemcode"+fila+" option:selected").each(function () {
				    texto = $(this).attr('value');
				    textoid = $(this).attr('id');
				 	});	
				 	$("#itemname"+fila).val(texto);
				}
				 

				if (opcion == 2)
				{
				 	$("#itemname"+fila+" option:selected").each(function () {
				    texto = $(this).attr('value');
				    textoid = $(this).attr('id');
				 	 });
				
					$("#itemcode"+fila).val(texto);
				}

				 

				if (texto == '')
				{
					$("#textoname"+fila).val("");
					$("#price"+fila).val("");
					$("#currency"+fila).val("");
					$("#quantity"+fila).val(0);
					$("#linetotal"+fila).val("");	
					return 0;
				}

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

			function BuscarItem_2(fila)
			{
				var texto = "";
				var textoid = "";
				 $("#itemcode"+fila+" option:selected").each(function () {
				    texto = $(this).attr('value');
				    textoid = $(this).attr('id');
				 	 });
				
				var myString = String(textoid); 
				var myArray = textoid.split(';');
				
				//$("#textoname"+fila).val("");
				$("#price"+fila).val("");
				$("#currency"+fila).val("");
				$("#quantity"+fila).val(0);
				$("#linetotal"+fila).val("");

				//$("#textoname"+fila).val(myArray[0]);
				$("#price"+fila).val(myArray[1]);
				$("#currency"+fila).val(myArray[2]);
				$("#quantity"+fila).val(1);

				valor_total(fila);
				
			}

			function validar_cantidad(valor, fila){

				valor = parseInt(valor)
				//Compruebo si es un valor numérico
			    if (isNaN(valor)) {
			        //entonces (no es numero) devuelvo el valor cadena vacia
			        alert("Ingrese una cantidad valida");
			        $("#quantity"+fila).val(0);
			        return 0
			    }else{
			        //En caso contrario (Si era un número) devuelvo el valor
			        if (valor <= 0){
			        	alert("Ingrese una cantidad valida");
			        	$("#quantity"+fila).val(0);
			        return 0
			        }
			        else
			        	$("#quantity"+fila).val(valor);
			        return valor
			    }

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
		    	$("#totaldoc").val(valor_documento(40));
		    	valor_comision(linea);

		    }

		    function valor_comision(linea){
		    	var cant   = $("#quantity"+linea).val();
		    	var precio = $("#price"+linea).val();
		    	var precioventa = $("#campoextra1"+linea).val();
				if (precioventa > 0 || precioventa != '' )
				{
					var total = (precio - precioventa) * cant;
		    		$("#comision"+linea).val(total);	
				}
				else{
					$("#comision"+linea).val(0);		
				}
				$("#totalcomision").val(valor_total_comision(40));
			}

			function valor_documento(lineas)
			{
				
				var totaldoc = 0;
				var valor;
				
				for (var i = 0; i < lineas ; i++) {
					valor = $("#linetotal"+i).val();
					if (!/^([0-9])*$/.test(valor) || valor == '')
					{}
					else{
						
						totaldoc = totaldoc + parseInt(valor);	
					}
				};
				//alert(totaldoc);
				return totaldoc;
			}
			function valor_total_comision(lineas)
			{
				
				var totalcomision = 0;
				var valor;
				
				for (var i = 0; i < lineas ; i++) {
					valor = $("#comision"+i).val();
					if (!/^([0-9])*$/.test(valor) || valor == '')
					{}
					else{
						
						totalcomision = totalcomision + parseInt(valor);	
					}
				};
				//alert(totaldoc);
				return totalcomision;
				
			}

		    function setCombo(valor, fila)
			{
			  var Cadena;

			  combo = document.getElementById("itemcode"+fila);
			  valor = valor.toUpperCase();
			  if (valor.length > 2)
			  {
			    
			    for (i=1; i<combo.length; i++)
			    {
			        //alert(combo.options[i].text+" :: "+valor+" :: "+combo.options[i].text.indexOf(valor));
			  		Cadena = "";
			  		Cadena = combo.options[i].id.toUpperCase();
			      if (Cadena.indexOf(valor) == 0) 
			      {
			        combo.selectedIndex = i;
			       //alert("Index: "+combo.selectedIndex); 
			      }
			    }
			    BuscarItem_2(fila);
			  }
						
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
	
	.campo_texto{
		font-family: Arial;
		font-size: 14px;
	}
	.campo_texto input{
		border-radius: 0.5;
		border: solid 1px;
		margin: 2px;
		padding: 2px;	
	}

	tr #titulo_estatico{
		position: static;
	}


	</style>	
</head>
<body background="imagenes/fondo2.png">
	<?php
	if (isset($_SESSION["sudlogin"]))
	{
	?>

	<div id="cont_form">
	<form action="" method="post" name="formsoc" onsubmit="return validar()">
		<label>Sociedad</label>
		<select id="selector" name="sociedad" onChange="javascript:submit()" style="width:200px;"> 
		<!-- mostrarDiv(this.value); onChange="mostrarDiv(this.value);" -->
		<option value="" ></option>
		<?php
		///INICIO DEL CUERPO DEL MENU ***************
		$sql = "SELECT j0.idsoc, j0.cmpname, j0.identificador 
				FROM srgc as j0
				Inner Join companiasxperfiles as j1 on j0.idsoc = j1.idcia
				WHERE j0.activo = 'Y'
				And j1.idperfil = '".$_SESSION["sudperfil"]."'";
		
		$result = $conexionMysql->db->Execute($sql);
		while ($row=$result->FetchNextObj())
		{ 
			if(isset($_SESSION["sudlogin"]) && $identificador <> '' ){
				if( $row->identificador == $identificador){
					?>
					<option value="<?= $row->identificador ?>" selected><?= $row->cmpname ?></option>
				<?php
				}
				else{
					?>
					<option value="<?= $row->identificador ?>" ><?= $row->cmpname ?></option>		
				<?php
				}
			}
			else{
			?>
			<option value="<?= $row->identificador ?>" ><?= $row->cmpname ?></option>
			<?php
			}
		}
		?>
		</select>
	</form>
	</div>

	<?php
	}
	
	$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
	mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());
	
	$sql  = "SELECT campoextra1, login FROM usuarios ";
	$sql .= " Where login = '".$_SESSION['sudlogin'] ."'";
	
	$result = mysql_query($sql,$link) or die(mysql_error());
	if ($row_c = mysql_fetch_assoc($result))
	{
		$campoextra1 = $row_c[campoextra1];
	}

	$sql  = "SELECT * FROM ocrd ";
	$sql .= " Where identificador = '$identificador'";
	$sql .= " Order by cardname";
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$cliente[] = $row[cardcode];
		$namecliente[] = $row[cardname];
	}

	$sql  = "SELECT j0.itemcode, j0.itemname, j1.pricelist, j1.price, j1.currency 
			 FROM oitm as j0
			 Inner Join itm1 as j1 on j0.itemcode = j1.itemcode	";
	$sql .= " Where j0.identificador = '$identificador'";
	$sql .= " Order By j0.itemname";
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
	if ($identificador <> ''){
		?>
		<div id="pedido">
		<table class="tabla_pedido">
			<tr>
				<td class="subtitulo">
				Orden de Venta
				<script>document.write(document.formsoc.sociedad.value);</script>
				</td>
			</tr>
			<tr>
				<td>
				<form name="form" id="formulario" action="" method="post" onsubmit="return validar();">
					<table>
						<tr>
							<td id="label1">
								Cliente
							</td>
							<td id="campo1">
								<select name="cardcode" id="cardcode1" style="width:200px;" onchange="BuscarCli(1);">
								<option></option>
									<?php 
										foreach ($cliente as $key => $value) {
										    echo "<option value=\"$value\" id=\"$namecliente[$key]\">".$value." - " .$namecliente[$key]."</option>\n";  
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td id="label1">
								Nombre Cliente
							</td>
							<td id="campo1">
								<select name="cardname1" id="cardname1" style="width:300px;" onchange="BuscarCli(2);">
								<option></option>
									<?php 
										foreach ($cliente as $key => $value) {
										    echo "<option value=\"$value\" id=\"$namecliente[$key]\">".$namecliente[$key]."</option>\n";  
										}
									?>
								</select>
							</td>
						</tr>
						<!--tr>
							<td id="label1">
								Nombre
							</td>
							<td id="campo1">
								<input type="text" name="cardname" id="cardname" size="60" readonly="readonly">
							</td>
						</tr-->
						<tr>
							<td id="label1">
								Comentario:
							</td>
							<td id="campo1">
								<input type="text" name="comentario" maxlength="100" size="60" />
							</td>
						</tr>
						
					</table>
					<br/>
					<div class="tabla_detalle">
					<table border=1 width="100%">
						<tr id="titulo_estatico">
							<td class="titulo_matriz" width="3%">
							#
							</td>
							<td class="titulo_matriz" width="15%">
								N&uacute;mero Art&iacute;culo
							</td>
							<td class="titulo_matriz" width="29%">
								Descripci&oacute;n de Art&iacute;culo
							</td>
							<td class="titulo_matriz" width="8%">
								Cantidad
							</td>
							<!--td class="titulo_matriz" >
								Moneda
							</td-->
							<td class="titulo_matriz" width="10%">
								Precio unitario
							</td>
							<?php
							if ($campoextra1 == 'Y')
							{  ?>
								<td class="titulo_matriz" >
									Precio Vendedor
								</td>	
								<td class="titulo_matriz" >
									Comision
								</td>	
							<?php
							}
							?>
							<td class="titulo_matriz" >
								Total
							</td>
						</tr>
					
						<?php
						$fila = 0;
						while($fila < 10)
						{	
						?>
							
							<tr onMouseOver="this.style.background='#FFFFCC'" onMouseOut = "this.style.background=''" 
							 bgcolor="<?= $Color_Celda1; ?>" bordercolor="<?= $Color_Celda1; ?>">
							<td align="center" class="matriz_campo" width="2%">
							<?= $fila + 1; ?>
							</td>
							<td class="matriz_campo" width="15%">
								<select name="itemcode[]" id="itemcode<?= $fila; ?>" style="width:150px;" 
								onchange="BuscarItem(<?= $fila; ?>, 1);">
								<option></option>
									<?php 
										foreach ($item as $key => $value) {
echo "<option value=\"$value\" id=\"$nameitem[$key];$precio[$key];$moneda[$key]\">".$value." - ".$nameitem[$key]."</option>\n";  
										}
									?>
								</select>
							</td>
							<td class="matriz_campo" width="20%">
								<select name="itemname[]" id="itemname<?= $fila; ?>" style="width:250px;" 
								onchange="BuscarItem(<?= $fila; ?>, 2);">
								<option></option>
									<?php 
										foreach ($item as $key => $value) {
echo "<option value=\"$value\" id=\"$nameitem[$key];$precio[$key];$moneda[$key]\">".$nameitem[$key]."</option>\n";  
										}
									?>
								</select>

								<!--input type="text" id="<?= "textoname".$fila; ?>" size="50" onKeyUp="setCombo(this.value,<?= $fila ?>)" onBlur="BuscarItem(<?= $fila; ?>);" /-->
								
							</td>
							<td class="matriz_campo" width="8%">
								<input type="number" name="quantity[]" id="<?= "quantity".$fila; ?>" size="10"
								onchange="valor_total('<?= $fila; ?>');" onBlur="return validar_cantidad(this.value,<?= $fila ?>)" />
							</td>
							
							<input type="hidden" id="<?= "currency".$fila; ?>" size="2" readonly/>
							<td class="matriz_campo" width="10%">
								<input type="number" name="price[]" id="<?= "price".$fila; ?>" size="10" 
								onchange="valor_total('<?= $fila; ?>');" />
							</td>
							<?php
							
							if ($campoextra1 == 'Y')
							{  ?>
								<td class="matriz_campo">
									<input type="number" name="campoextra1[]" id="<?= "campoextra1".$fila; ?>" size="10" 
									  onchange="valor_comision('<?= $fila; ?>');" />
								</td>	
								<td class="matriz_campo">
									<input type="number" id="<?= "comision".$fila; ?>" size="10" readonly />
								</td>
							<?php 
							}
							?>
							<td class="matriz_campo">
								<input type="number" name="linetotal[]" id="<?= "linetotal".$fila; ?>" size="12" readonly />
							</td>
							</tr>

							<tr id="<? echo "celda".$fila; ?>" style="display: none">
								<td align="center" colspan="6">
									<input type="text" id="<?= "q".$fila; ?>" name="q" onkeyup="Buscar(<?= $fila; ?>);" autofocus />
								    <select id="<?= "tipo".$fila; ?>">
								    	<option value="itemcode" selected>N&uacute;mero de Art&iacute;culo</option>
								    	<option value="itemname" >Descripci&oacute;n de Art&iacute;culo</option>
								    </select>
								    <br/>
								    <div id="<?= "resultado".$fila; ?>" style="display:none">
								    	Buscando ...
								    </div>
								</td>
							</tr>
						<?php
						$fila = $fila + 1;
						 } //fin del while
						?>
						
					</table>
					</div>
				
				</td>
			</tr>
			<tr>
				<td width="98%">
					
					<input type="hidden" name="identificador" value="<?= $identificador; ?>" />
					<input class="boton_submit" type="submit" value="Crear" />
					&nbsp; &nbsp; &nbsp;
					<input class="boton_submit" type="button" value="Cancelar" onclick="javascript:location.href='<?= $_SERVER['HTTP_REFERER']; ?>';" />
					&nbsp; &nbsp; &nbsp;
						<?php
						if ($campoextra1 == 'Y')
						{  ?>
							Total Comision
							<input class="campo_texto" type="text" id="totalcomision" size="12" readonly />	&nbsp;					
						<?php 
						} ?>

						Total Documento
						<input class="campo_texto" type="text" id="totaldoc" size="12" readonly />
				</td>
				
			</tr>
		</form>	
		</table>
		</div>

	<?php	
	}
	?>
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