<?php session_start();
header("Content-Type: text/html;charset=utf-8");
require_once('conexion/conf.php');
include $gloInclude . "/adodb.inc.php"; 
include $clase_BD;
include ("conexion/Conect_DB.php");
$ArchivoCalendar = "javascript/calendar_1.php";
include ($ArchivoCalendar);
$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);
$identificador = $_POST['sociedad'];

$fecha = date("Y-m-d");
$hora  = date("His");

if (isset($_POST[fcustomer])){
	
	$identificador = $_POST[identificador];
	echo "sociedad: ".$identificador."<br>";

	$cont = 0;
	$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
	mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());
	mysql_query("SET NAMES 'utf8'");
	

	$sql  = "Select ifnull(max(callID) + 1,1) as consec from oscl";
	$result = mysql_query($sql,$link) or die(mysql_error());
	
	if ($row = mysql_fetch_assoc($result))
	{
		$callID = $row[consec];
	}
	else{
		$callID = 1;
	}


	$docnum 	= "";
	$doctype 	= "";
	$createdate = $fecha;
	$createTime	= $hora;
	$cardcode	= $_POST[fcustomer];

	$sql  = "Select cardname from ocrd";
	$sql .= " Where cardcode = '$cardcode' and id_integra = '$identificador'";
	$result_c = mysql_query($sql,$link) or die(mysql_error());
	$row_c = mysql_fetch_assoc($result_c);
	$cardname	= "";
	$cardname	= $row_c[cardname];
	$docusap    = "";
	$docrate	= "";
	$groupnum	= "";
	$slpname	= $_SESSION["sudlogin"];
	$usersign	= $_SESSION["sudlogin"];

	
	if ($_POST[fsubject] == ''){
		$subject = "";
	}
	else{
		$subject = $_POST[fsubject];	
	}
	if ($_POST[fdescrption] == ''){
		$descrption = "";
	}
	else{
		$descrption = $_POST[fdescrption];	
	}

	if ($_POSTf[resolution] == ''){
		$resolution = "";
	}
	else{
		$resolution = $_POST[fresolution];	
	}

	//llama el custmrName de acuerdo al customer elegido en el formulario
	$customer = $_POST[fcustomer];
	$sql ="SELECT cardname from ocrd where cardcode = '$customer' and id_integra = '$identificador' ";
	$custmrNameqry = mysql_query($sql,$link) or die (mysql_error());
	$custmrNamerow = mysql_fetch_assoc($custmrNameqry);
	if ($customer <> ''){
		$custmrName = $custmrNamerow[cardname];
	}


	$sql = "SELECT * FROM oscl WHERE callid = '-1'";
	$resultset= $conexionMysql->db->Execute($sql);

	//iniciar arreglo que contiene los datos a insertar, asignar los valores, y preparar sentencia
	$record = array();
	$fechaRegistro = date("Ymd");
	$horaRegistro =  date("Gis") . "00";
	//
	$record["callID"] = $callID;
	$record["subject"] = $subject;
	$record["customer"] = $_POST[fcustomer];
	$record["custmrName"] = $custmrName;
	$record["status"] = $_POST[fstatus];
	$record["priority"] = $_POST[fpriority];
	$record["createdate"] = $createdate;
	$record["createTime"] = $createTime;
	$record["origin"] = $_POST[forigin];
	$record["problemType"] = $_POST[fproblemType];
	$record["callType"] = $_POST[fcallType];
	$record["technician"] = $_POST[ftechnician];
	$record["assignee"] = $_POST[fassignee];
	$record["descrption"] = $descrption;
	$record["resolution"] = $resolution;
	$record["fechaEvento"] = $_POST[ffechaEvento];
	$record["origenEvento"] = $_POST[forigenEvento];
	$record["area"] = $_POST[farea];
	$record["tipoAccion"] = $_POST[ftipoAccion];		
	$record["impactoPersonas"] = $_POST[fimpactoPersonas];
	$record["impactoAmbiental"] = $_POST[fimpactoAmbiental];
	$record["impactoEconomico"] = $_POST[fimpactoEconomico];
	$record["probabilidad"] = $_POST[fprobabilidad];
	$record["severidad"] = $_POST[fseveridad];					
	$record["causaInmediata"] = $_POST[fcausaInmediata];
	$record["COMCI"] = $_POST[fCOMCI];
	$record["causaBasica"] = $_POST[fcausaBasica];
	$record["causaRaiz"] = $_POST[fcausaRaiz];
	$record["causaFalla"] = $_POST[fcausaFalla];					
	
	if ($resultset)
		$sql = $conexionMysql->db->GetInsertSQL($resultset, $record);

	//insertar registro
	$conexionMysql->db->Execute($sql); 	

	$sql  = "INSERT Into oscl (callID, subject, customer, custmrName, status, priority, createdate, createTime";
	$sql .= ", origin, problemType, callType, technician, assignee, descrption, resolution, fechaEvento, origenEvento";
	$sql .= ", area, tipoAccion, impactoPersonas, impactoAmbiental, impactoEconomico, probabilidad, severidad, causaInmediata";
	$sql .= ", COMCI, causaBasica, causaRaiz, causaFalla)";
	$sql .= " VALUES('$callID', '$subject', '$customer', '$custmrName', '$status', '$priority', '$createdate', '$createTime', '$origin'";
	$sql .= ", '$problemType', '$callType', '$technician', '$assignee', '$descrption','$resolution', '$fechaEvento', '$origenEvento'";
	$sql .= ", '$area', '$tipoAccion', '$impactoPersonas', '$impactoAmbiental', '$impactoEconomico','$probabilidad', '$severidad', '$causaInmediata'";
	$sql .= ", '$COMCI', '$causaBasica', '$causaRaiz', '$causaFalla')";	

		//  Select de los datos insertados

	$sql = "Select *, j0.callID, j0.subject, j0.customer, j0.custmrName, j1.Name estado, j0.priority, j0.createDate, j2.Name Actividad,";
	$sql .=" j3.Name Ubicacion, j4.Name Proceso, (j5.firstName + ' ' + j5.middleName + '  ' + j5.lastName) employee, j6.U_NAME Jefe, j0.descrption,";
	$sql .=" j0.resolution ";
	$sql .= "from oscl as j0 ";
	$sql .= "left join oscs j1 on j0.status = j1.statusID "; 
	$sql .= "left join osco j2 on j0.origin = j2.originID ";
	$sql .= "left join oscp j3 on j0.problemTyp = j3.prblmTypID ";
	$sql .= "left join osct j4 on j0.callType = j4.callTypeID ";
	$sql .= "left join ohem j5 on j0.technician = j5.empID ";
	$sql .= "left join ousr j6 on j0.assignee = j6.USERID ";
	$sql .= "where j0.callID = '$callID' ";
	$sql .= "Order by j0.callID";

$result_servicecall = mysql_query($sql,$link) or die(mysql_error());

if ($row_servicecall = mysql_fetch_assoc($result_servicecall))
{
	echo "<h1>Referencia SMC : ".$callID."</h1>";
	echo "<h2>Reportado por : ".$row_servicecall[employee]."</h2>";
		//*******	

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

	<div id="smc">


		<table width="100%">
			<tr>
				<td width="100%">
					<div id="Exportar_a_Excel">
						<table class="tabla_pedido">
							<tr>
								<td class="subtitulo">
									Reporte SMC
									&nbsp; &nbsp; Referencia SMC: <?= $callID; ?>
								</td>
							</tr>
							<tr>
								<td>
									
									<!--  ++++++   CABECERA   +++++++   -->	
									<table>
										<tr>
											<td id="label1">
												Fecha Creación
											</td>
											<td id="campo1">
												<label id="label"><?= $row_servicecall[createDate]; ?></label>
											</td>											
											<td id="label1">
												Prioridad: 
											</td>
											<td id="campo1">
												<label id="label">
													<?php if($row_servicecall[priority] == 'L'){
														echo "Bajo";
													}
													else if ($row_servicecall[priority] == 'M'){
														echo "Medio";
													}
													else if ($row_servicecall[priority] == 'H'){
														echo "Alto";
													}
													else{
														echo "N/A";
													}
													?>
												</label>
											</td>
										</tr>
										<tr>
											<td id="label1">
												Nombre del Evento
											</td>
											<td id="campo1">
												<label id="label"><?= $row_servicecall[subject]; ?></label>
											</td>
										</tr>
										<tr>
											<td id="label1">
												Cod. Dueño del Proceso:
											</td>
											<td id="campo1">
												<label id="label"><?= $row_servicecall[customer]; ?></label>
											</td>
											<td id="label1">
												Dueño del Proceso:
											</td>
											<td id="campo1">
												<label id="label"><?= $row_servicecall[custmrName]; ?></label>
											</td>

										</tr>

										<tr>
											<td id="label1">
												Proceso:
											</td>
											<td id="campo1">
												<label id="label"><?= $row_servicecall[Proceso]; ?></label>
											</td>

											<td id="label1">
												Reportado por:
											</td>
											<td id="campo1">
												<label id="label"><?= $row_servicecall[employee]; ?></label>
											</td>
										</tr>
										<tr>
											<td id="label1">
												Identificacion del Area
											</td>
											<td id="campo1">
												<label id="label"><?= $row_servicecall[Ubicacion]; ?></label>
											</td>
											<td id="label1">
												Descripcion del evento y detalles de la investigacion:
											</td>
											<td id="campo1">
												<label id="label"><?= $row_servicecall[descrption]; ?></label>
											</td>
										</tr>
										<tr>
											<td id="label1">
												Origen Evento:
											</td>
											<td id="campo1">
												<label id="label"><?= $row_servicecall[origin]; ?></label>
											</td>
										</tr>

										<tr>
											<td id="label1">
												Solucion
											</td>
											<td id="campo1">
												<label id="label"><?= $row_servicecall[resolution] ?></label>
											</td>

										</tr>

									</table>

									<br/>
									<td>
										<!--input class="boton_submit" type="submit" value="Crear" /-->
										&nbsp; &nbsp; &nbsp;
										<input class="boton_submit" type="button" value="Cancelar" onclick="javascript:location.href='<?= $_SERVER['HTTP_REFERER']; ?>';" />
									</td>											
								</td>
							</tr>
							<!--/form-->	
						</table>
					</div>
				</td>
			</tr>
		</table>
		<table border="1" align="center" style="border-collapse:collapse;">
			<tr>
				<td align="center" valign="middle" onClick="javascript:location.href='<?= "tiquete_layout.php?id=".$docentry ?>';" >
					<img src="<? echo $gloRutaPublica . "/imagenes/find.gif"; ?>" width="20" height="20" alt="Layout" style="cursor:pointer">
				</td>
			</tr>
		</table>
	</div>
		<?php

	}
	else{
		echo "<br><h1>No ha sido posible ingresar crear la llamada de servicio, intente de nuevo. ";
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
	<title>Crear Llamada de Servicio</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="estilos_sap.css" />
	<link rel="stylesheet" type="text/css" href="calendar.css" />
	<script src="jquery.js"></script>
	<script type="text/javascript" src="cal.js"></script>
	<link href="<?php echo $gloRutaPublica . "/estilos/calendar-system.css"; ?>" rel="stylesheet" type="text/css" media="all">
	<Script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>
	<!-- programa principal del calendario -->
	<Script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/calendar.js"; ?>"></script>	
	<!-- lenguaje del calendario -->
	<Script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/lang/calendar-es.js"; ?>"></script>		
	<!-- libreria para personalizar el calendario -->
	<Script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/calendar-setup.js"; ?>"></script>
	<script language="javascript" src="/javascript/scripts.js"></script>
	<script language="javascript">
	$("#select").change(function () {
		var str = "";
		$("select option:selected").each(function () {
			id = $(this).value;
			if (id == ''){
				$("#smc").hide();
				return 0;		
			}
			else {
				$.post("frame_smc.php", {id:id}, function(datos)
				{
						//El div que muestra los datos impresos en php tiene id="formatos"
						$("#smc").html(datos);
					});

					//$("#pedido").slideDown(200);
					return 0;		
				}    
			});
	})

	function mostrarDiv(id) {

		var jsid = id;
		if (id == ''){
			$("#smc").hide();
			return 0;		
		}
		else {
			$.post("frame_smc.php", {id:id}, function(datos)
			{
					//El div que muestra los datos impresos en php tiene id="formatos"
					$("#smc").html(datos);
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
			    	$.post("buscar_empleado_ocrd_div.php", {dato:texto,tipo:tipo,fila:res1}, function(datos)
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
				nextinput = 0;
				if (opcion == 1)
				{
					$("#customer1 option:selected").each(function () {
						texto = $(this).attr('value');
						textoid = $(this).attr('id');
					});
					$("#custmrName1").val(texto);

				}
				if (opcion == 2)
				{
					$("#custmrName1 option:selected").each(function () {
						texto = $(this).attr('value');
						textoid = $(this).attr('id');
					});
					$("#customer1").val(texto);
				}
				
				$("#custmrName1").val(textoid);




			}




			function validar(){

				if (document.form.fcustomer.value == ''){
					alert("Es necesario que elija un dueño de proc");
					document.form.fcustomer.focus();
					return false;
				}
				// if (document.form.fcustmrName.value == ''){
				// 	alert("Es necesario que elija un dueño de proc");
				// 	document.form.fcustmrName.focus();
				// 	return false;
				// }



				if (confirm("Esta Seguro(a) de continuar?"))
				{
					$("#cargando_datos").html("<div align=left><font color=red face=arial size=3>&nbsp; &nbsp; La llamada de servicio esta siendo creada, espere un momento por favor. ...</font></div>");
					return true;

				}
				else
				{
					return false;
				} 

				return true;
			}

			function maximaLongitud(texto,maxlong)
			{
				var tecla, int_value, out_value;

				if (texto.value.length > maxlong)
				{
				/*con estas 3 sentencias se consigue que el texto se reduzca
				al tamaño maximo permitido, sustituyendo lo que se haya
				introducido, por los primeros caracteres hasta dicho limite*/
				in_value = texto.value;
				out_value = in_value.substring(0,maxlong);
				texto.value = out_value;
				alert("La longitud máxima es de " + maxlong + " caractéres");
				return false;
			}
			return true;
		}
		function confirmar(){
			
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
			border: solid 1px;
			position: static;
		}

		#obligatorio{
			font-family: times, arial;
			font-size: 9px;
			color: blue;
			margin: 3px;
		}


		</style>	
</head>
<body>
	<?php
	if (isset($_SESSION["sudlogin"]))
	{
		?>

		<div id="cont_form">
			<form action="" method="post" name="formsoc" onsubmit="return validar()" > <!--  -->
				<label>Sociedad 
				</label>
				<select id="selector" name="sociedad" onChange="javascript:submit()" style="width:200px;"> 
					<option value="" ></option>
					<?php
	///INICIO DEL CUERPO DEL MENU ***************
					$sql = "SELECT j0.idsoc, j0.cmpname, j0.identificador, j0.id_integra
					FROM srgc as j0
					Inner Join companiasxperfiles as j1 on j0.idsoc = j1.idcia
					WHERE j0.activo = 'Y'
					And j1.idperfil = '".$_SESSION["sudperfil"]."'"
					;
					$result = $conexionMysql->db->Execute($sql);
					while ($row=$result->FetchNextObj())
					{ 
						if(isset($_SESSION["sudlogin"]) && $identificador <> '' ){
							if( $row->id_integra == $identificador){
								?>
								<option value="<?= $row->id_integra ?>" selected><?= $row->cmpname ?></option>
								<?php
							}
							else{
								?>
								<option value="<?= $row->id_integra ?>" ><?= $row->cmpname ?></option>		
								<?php
							}
						}
						else{
							?>
							<option value="<?= $row->id_integra ?>" ><?= $row->cmpname ?></option>
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
	mysql_query("SET NAMES 'utf8'");

	$sql  = "SELECT cardcode, cardname FROM ocrd ";
	$sql .= " Where id_integra = '$identificador' And estado = 'A' And groupcode = '103'";
	$sql .= " Order by cardname";

	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$cliente[] = $row[cardcode];
		$namecliente[] = $row[cardname];
	}

	$sql = "SELECT statusID, Name FROM oscs ";
	$sql .="Where id_integra = '$identificador'";
	$sql .="Order by Name";

	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$statusID[] = $row[statusID];
		$nameStatus[] = $row[Name];
	}

	$sql  = "SELECT  name FROM empleado ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by name";
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$empleado[] = $row[name];
	}


	?>
	<span id="obligatorio">(*)</span> campos obligatorios
	<?php
	if ($identificador <> ''){
		?>
		<div id="smc">
			<table class="tabla_smc">
				<tr>
					<td class="subtitulo">
						Formato  SMC

					</td>
				</tr>
				<tr>
					<td>

						<form name="form" id="formulario" action="" method="post" onsubmit="return validar();"  enctype=multipart/form-data > 
							<input type="hidden" name="identificador" id="identificador" value="<?= $identificador; ?>" />


							<!--  INICIO CABECERA  -->
							<table>
								<tr>
									<td id="label1">
										Dueño del proceso <span id="obligatorio">(*)</span>
									</td>
									<td id="campo1">
										<select name="fcustomer" id="customer1" style="width:200px;" onchange="BuscarCli(1);">
											<option></option>
											<?php 
											foreach ($cliente as $key => $value) {
												echo "<option value=\"$value\" id=\"$cliente[$key]\">".$value." - " .$namecliente[$key]."</option>\n";  
											}
											?>
										</select>
									</td>

									<td id="label1">
										Fecha de Creaci&oacute;n:  
									</td>
									<td id ="campo1" size="14" type="text" READONLY name="docdate1" title="dd-mm-yyyy"> 
										<?= date('d-m-Y'); ?>
									</td>

								</tr>
								<tr>
									<td id = "label1">
										Estado del Evento 
									</td>
									<td id="campo1">
										<select name="fstatus" id="status1">
											<option></option>
											<?php
											foreach ($statusID as $key => $value) {
												echo "<option value=\"$value\" id=\"$nameStatus[$key]\">".$nameStatus[$key]."</option>\n";
											}

											?>
										</select>
									</td>
								</tr>


								<tr>
									<td id="label1">
										Nombre del Evento : 
									</td>
									<td id="campo1" colspan=5>
										<input type="text" name="fsubject" maxlength="200" size="127" />
									</td>
								</tr>
								<tr>
									<td id="label1" colspan=5>
										Descripción del Evento
									</td>

								</tr>
								<tr>
									<td  id="descriptiontxt" colspan="5">
										<textarea style="width:90%; height:100px;" name="fdescrption">Inserte la descripcion del evento aqui</textarea>
									</td>

								</tr>


							</table>
							<!--  FIN CABECERA  -->
							<br/>

						</td>
					</tr>
<!-- 			<tr>
			<td width="100%">
				<table width="90%">
					<tr>
						<td width="20%" valign="top">
							Comentarios: &nbsp; &nbsp; &nbsp;
						</td>
						<td >
							<textarea name="comentarios" rows="5" cols="40" onKeyUp="return maximaLongitud(this,100)"></textarea>
						</td>
					</tr>
				</table>
			</td>
		</tr>-->
		<tr> 
			<td width="80%">
				
				<input type="hidden" name="identificador" value="<?= $identificador; ?>" />
				<input class="boton_submit" type="submit" value="Crear" />
				&nbsp; &nbsp; &nbsp;
				<input class="boton_submit" type="button" value="Cancelar" onclick="javascript:location.href='<?= $_SERVER['HTTP_REFERER']; ?>';" />
				&nbsp; &nbsp; &nbsp;
<!-- 					Total Documento &nbsp; $
				<input class="campo_texto" type="text" id="totaldoc" size="12" readonly />
				&nbsp; &nbsp; USD
				<input class="campo_texto" type="text" id="totaldocext" size="12" readonly /> -->
			</td>
		</tr>
	</form>	
</table>
</div>

<?php	
}
?>
<div id="cargando_datos"></div>
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