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


if (isset($_POST[cardcode])){
	
	$identificador = $_POST[identificador];
	echo "sociedad: ".$identificador."<br>";

	$cont = 0;
	$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
	mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());
	mysql_query("SET NAMES 'utf8'");
	
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
	$doctotalext = 0;
	//echo "<br> docentry: ".$docentry."  ;  name: ". $_POST[name] . " ; fec: ".$_POST[docdate1];
	foreach($_POST[itemcode] as $key => $value){
		//echo "<br>Item: ".$_POST[itemcode][$key]." ; Precio: ".$_POST[price][$key];
		if ($_POST[itemcode][$key] != '')
		{
			$item 	= "";
			$item 	= $_POST[itemcode][$key];
			
			$sql  = "Select itemname from oitm";
			$sql .= " Where itemcode = '$item' and id_integra = '$identificador'";
			
			$result = $conexionMysql->db->Execute($sql);
			if ( $row_p = $result->FetchNextObj())
			{
				$dscription =  $row_p->itemname;
			}
			else{
				$dscription = "";
			}
			$cant	= "";
			$cant	= $_POST[quantity][$key];
			$moneda = $_POST[currency][$key];;
			//$moneda = $_POST[currency][$key];
			$precio	= "";
			$precio	= $_POST[price][$key];
			$total	= "";
			$total 	= $_POST[linetotal][$key];
			$user	= "";
			$user	= $_SESSION["sudlogin"];
			if ($moneda == '$'){
				$doctotal = $doctotal + $total;	
			}
			if ($moneda == 'USD'){
				$doctotalext = $doctotalext + $total;
			}
			
			$campoextra1 = 0;
			$comision = 0;
			
			$sql = "SELECT * FROM rdr1 WHERE docentry = '-1'";
			$resultset= $conexionMysql->db->Execute($sql);

			//iniciar arreglo que contiene los datos a insertar, asignar los valores, y preparar sentencia
			$record = array();
			$fechaRegistro = date("Ymd");
			$horaRegistro =  date("Gis") . "00";
			//
			$record["docentry"] = $docentry;
			$record["itemcode"] = $item;
			$record["dscription"] = $dscription;
			
			$record["fechaini"] = $_POST[fechaini][$key];
			$record["fechafin"] = $_POST[fechafin][$key];
			$fecha1 = cambiarFormatoFecha($_POST[fechaini][$key]);
			$fecha2 = cambiarFormatoFecha($_POST[fechafin][$key]);
			$record["numdia"] = restaFechas($fecha1,$fecha2);
			$record["quantity"] = $cant;
			$record["price"] = $precio;
			$record["currency"] = $_POST[currency][$key];
			$record["linetotal"] = $total;
			$record["project"] = $_POST[project][$key];
			$record["prjname"] = $_POST[prjname][$key];
			$record["paracontoper"] = $_POST[paracontoper][$key];
			$record["tipooperacion"] = $_POST[tipooperacion][$key];
			$record["pozolinea"] = $_POST[pozolinea][$key];
			//$record["taxcode"] = $_POST[taxcode][$key];
			//$record["ordentrabajo"] = $_POST[ordentrabajo][$key];
			$record["freetxt"] = $_POST[freetxt][$key];
			
			$record["empleado1"] = $_POST[empleado1][$key];
			$record["poremp1"] = $_POST[poremp1][$key];
			$record["aliemp1"] = $_POST[aliemp1][$key];
			$record["empleado2"] = $_POST[empleado2][$key];
			$record["poremp2"] = $_POST[poremp2][$key];
			$record["aliemp2"] = $_POST[aliemp2][$key];
			$record["empleado3"] = $_POST[empleado3][$key];
			$record["poremp3"] = $_POST[poremp3][$key];
			$record["aliemp3"] = $_POST[aliemp3][$key];
			$record["empleado4"] = $_POST[empleado4][$key];
			$record["poremp4"] = $_POST[poremp4][$key];
			$record["aliemp4"] = $_POST[aliemp4][$key];
			$record["empleado5"] = $_POST[empleado5][$key];
			$record["poremp5"] = $_POST[poremp5][$key];
			$record["aliemp5"] = $_POST[aliemp5][$key];
			$record["empleado6"] = $_POST[empleado6][$key];
			$record["poremp6"] = $_POST[poremp6][$key];
			$record["aliemp6"] = $_POST[aliemp6][$key];
			$record["empleado7"] = $_POST[empleado7][$key];
			$record["poremp7"] = $_POST[poremp7][$key];
			$record["aliemp7"] = $_POST[aliemp7][$key];
			$record["empleado8"] = $_POST[empleado8][$key];
			$record["poremp8"] = $_POST[poremp8][$key];
			$record["aliemp8"] = $_POST[aliemp8][$key];
			$record["empleado9"] = $_POST[empleado9][$key];
			$record["poremp9"] = $_POST[poremp9][$key];
			$record["aliemp9"] = $_POST[aliemp9][$key];
			$record["empleado10"] = $_POST[empleado10][$key];
			$record["poremp10"] = $_POST[poremp10][$key];
			$record["aliemp10"] = $_POST[aliemp10][$key];

			$record["discprcnt"] = $_POST[discprcnt][$key];
			//$record["porcdescecop"] = $_POST[porcdescecop][$key];
			$record["dtllservicio"] = $_POST[dtllservicio][$key];
			//$record["text"] = $_POST[text][$key];
			//$record["linea"] = $_POST[linea][$key];
			//$record["tiquete"] = $_POST[tiquete][$key];
			//$record["docubase"] = $_POST[docubase][$key];
			//$record["calificacion1"] = $_POST[calificacion1][$key];
			//$record["calificacion2"] = $_POST[calificacion2][$key];
			
			$record["identificador"] = $identificador;
			$record["linenum"] = $key;

			$indice = date('ymd') . date('Hi') . substr(md5(date('s')),1,2);
			$nombre_archivo = $_FILES['anexo']['name'][$key];
			$tipo_archivo = $_FILES['anexo']['type'][$key];
			$tamano_archivo = $_FILES['anexo']['size'][$key];
			$temp_archivo = $_FILES['anexo']['tmp_name'][$key];

			$cadenaProcesada = strtolower($nombre_archivo); 
		    $b = array("á","é","í","ó","ú","ä","ë","ï","ö","ü","à","è","ì","ò","ù","ñ"," "); 
		    $c = array("a","e","i","o","u","a","e","i","o","u","a","e","i","o","u","n","_"); 
			$cadenaProcesada = str_replace($b, $c, $cadenaProcesada); 
			$nombre_archivo = $cadenaProcesada;

			$nombre_archivo = $indice . $key . "_" . $nombre_archivo;
			$archivo = "./anexos/" . $nombre_archivo;

			if (isset($_FILES['anexo']['name'][$key]) && $_FILES['anexo']['name'][$key] <> '')
			{
				
				if ($tamano_archivo < 60000000){
					if (move_uploaded_file($_FILES['anexo']['tmp_name'][$key], $archivo))
					{			}
					else{
						$nombre_archivo = "error cargando el archivo: ".$nombre_archivo;
						$archivo = "";
					}
				}
				else{
					$nombre_archivo = "error: el tamaño del archivo excede el limite de 60 Mb";
					$archivo = "";
				}
			}
			else{
				$archivo = "";
				$nombre_archivo = "";
			}
			$record["anexo"] = $nombre_archivo;
			$record["anexo_ruta"] = $archivo;
			$record["anexo_tamano"] = $tamano_archivo;

			if ($resultset)
				$sql = $conexionMysql->db->GetInsertSQL($resultset, $record);

			//insertar registro
			$conexionMysql->db->Execute($sql); 	
			$sql  = "Insert Into rdr1 (docentry, linenum, itemcode, dscription, quantity";
			$sql .= ", price, linetotal, slpcode, docdate, hora, currency, identificador, precioventa, comision)";
			$sql .= " Values('$docentry','$key', '$item', '$dscription', '$cant'";
			$sql .= ", '$precio', '$total', '$user', '$fecha', '$hora', '$moneda', '$identificador', '$campoextra1', '$comision')";
			//$result = $conexionMysql->db->Execute($sql);
			//$result = mysql_query($sql,$link) or die(mysql_error());
			//echo "<br>SQL: ".$sql;	
		}
		$cont++;
	}

	$docnum 	= "";
	$doctype 	= "";
	$docstatus 	= "";
	
	$docduedate = $fecha;
	$cardcode	= $_POST[cardcode];

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
	
	if ($_POST[name] == ''){
		$name 		= "";
	}
	else{
		$name 		= $_POST[name];	
	}
	if ($_POST[quienllama] == ''){
		$quienllama = "";
	}
	else{
		$quienllama = $_POST[quienllama];	
	}
	if ($_POST[unidad] == ''){
		$unidad = "";
	}
	else{
		$unidad = $_POST[unidad];	
	}

	if ($_POST[campo] == ''){
		$campo = "";
	}
	else{
		$campo = $_POST[campo];	
	}

	if ($_POST[operacion] == ''){
		$operacion = "";
	}
	else{
		$operacion = $_POST[operacion];	
	}

	if ($_POST[comentarios] == ''){
		$comentarios = "";
	}
	else{
		$comentarios = $_POST[comentarios];	
	}

	$sql = "SELECT * FROM ordr WHERE docentry = '-1'";
	$resultset= $conexionMysql->db->Execute($sql);

	//iniciar arreglo que contiene los datos a insertar, asignar los valores, y preparar sentencia
	$record = array();
	$fechaRegistro = date("Ymd");
	$horaRegistro =  date("Gis") . "00";
	//
	$record["docentry"] = $docentry;
	$record["cardcode"] = $cardcode;
	$record["cardname"] = $cardname;
	$record["name"] = $name;
	$record["numatcard"] = $_POST[numatcard];
	$record["docnum"] = $docnum;
	$record["docdate"] = $_POST[docdate1];
	$record["docduedate"] = $_POST[docduedate];
	$record["taxdate"] = $_POST[taxdate];
	
	$record["pozo"] = $_POST[pozo];
	$record["tiquete_fisico"] = $_POST[tiquete_fisico];
	$record["docusap"] = $docusap;
	$record["rephslofs"] = $_POST[rephslofs];
	$record["repcliente"] = $_POST[repcliente1] . " " . $_POST[repcliente2];
	$record["hora"] = $horaRegistro;
	$record["doctotal"] = $doctotal;
	$record["doctotalext"] = $doctotalext;
	$record["docstatus"] = $docstatus;
	$record["doctype"] = $doctype;
	$record["groupnum"] = $groupnum;
	$record["usersign"] = $usersign;
	$record["usuarioweb"] = $usersign;
	$record["identificador"] = $identificador;
	$record["id_integra"] = $identificador;
	$record["feccreacion"] = $fecha;
	$record["quienllama"] = $quienllama;
	$record["usugerido"] = $_POST[sugerido];
	$record["unidad"] = $unidad;
	$record["campo"] = $campo;
	$record["operacion"] = $operacion;
	$record["comentarios"] = $comentarios;
	$record["ucalidad"] = $_POST[ucalidad];
	$record["ucumplimiento"] = $_POST[ucumplimiento];
	$record["uejecucionw"] = $_POST[uejecucionw];
	$record["uequipo"] = $_POST[uequipo];
	$record["usiso"] = $_POST[usiso];
	$record["umedioa"] = $_POST[umedioa];
	
	if ($resultset)
		$sql = $conexionMysql->db->GetInsertSQL($resultset, $record);

	//insertar registro
	$conexionMysql->db->Execute($sql); 	

	$sql  = "Insert Into ordr (docentry, docnum, doctype, docstatus, docdate, docduedate, cardcode";
	$sql .= ", cardname, docrate, doctotal, groupnum, slpcode, usersign, hora, identificador, comentario)";
	$sql .= " Values('$docentry','$docnum', '$doctype', '$docstatus', '$docdate', '$docduedate', '$cardcode'";
	$sql .= ", '$cardname', '$docrate', '$doctotal', '$groupnum', '$slpname', '$usersign', '$hora', '$identificador', '$comentario' )";
	//echo "<br>SQL: ".$sql;
	
	//$result = $conexionMysql->db->Execute($sql);
	//$result = mysql_query($sql,$link) or die(mysql_error());
	//	echo "<br>sql:".$sql;

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

	
	if ($row_pedido = mysql_fetch_assoc($result_pedido))
	{
		echo "<h1>Referencia del pedido: ".$docentry."</h1>";
		echo "<h2>Se ha registrado un pedido para el Cliente: ".$cardname."</h2>";
		//echo "<h3>El total del pedido es: $ ".number_format($doctotal, 0, ',', '.')."</h3>";		
		$Total = $row_pedido[doctotal];
		$Totalext = $row_pedido[doctotalext];
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
									Orden de Venta 
									&nbsp; &nbsp; Referencia: <?= $docentry; ?>
									</td>
								</tr>
								<tr>
									<td>
									
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
													<label id="label"><?= $row_pedido[rephslofs]; ?></label>
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
												<!--td class="titulo_matriz" width="150px">
													% Descuento Ecopetrol
												</td-->
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
												<!--td class="titulo_matriz" width="150px">
													Calificaci&oacute;n 1
												</td-->
												<!--td class="titulo_matriz" width="150px">
													Calificaci&oacute;n 2
												</td-->
												<td class="titulo_matriz" width="250px">
													Adjuntos
												</td>
											</tr>

											<tr>
											<td colspan="100">
											<div class="tabla_detalle">
											<table border=0 >

											<?php
											$comentarios = $row_pedido[comentarios];
											$fila = 0;
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
													<!--td class="matriz_campo" >
														<label id="label"><?= $row_pedido[porcdescecop] ?></label> 
													</td-->
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
													<!--td class="matriz_campo" >
														<label id="label"><?= $row_pedido[calificacion1] ?></label>
													</td-->
													<!--td class="matriz_campo" >
														<label id="label"><?= $row_pedido[calificacion2] ?></label>
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
										Total Pedido: &nbsp; &nbsp; $  <?= number_format($Total, 2, '.', ','); ?>
													&nbsp; &nbsp; &nbsp; USD <?= number_format($Totalext, 2, '.', ','); ?>
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

				<!--  Tiquete Layout  -->
				<table border="1" align="center" style="border-collapse:collapse;">
					<tr>
						<td align="center" valign="middle" onClick="javascript:location.href='<?= "tiquete_layout.php?id=".$docentry ?>';" >
							<img src="<? echo $gloRutaPublica . "/imagenes/find.gif"; ?>" width="20" height="20" alt="Layout" style="cursor:pointer">
						</td>
					</tr>
				</table>
				<!-- fin Tiquete layout -->
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
				nextinput = 0;
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
				//alert(textoid);
				Traer_numero_referencia(textoid);
				Traer_persona_contacto(textoid);
				$("#tabla_lineas").html(""); 
		    	
				//TraerLineas(textoid);

			}

			function TraerLineas(valor)
		    {
		    	
				$("#tabla_lineas").html("<div align=center><font face=arial size=2>Cargando datos ...</font></div>");

				$("#cardcode1 option:selected").each(function () {
				    str = $(this).text();
				    id = $(this).attr('value');
				});

				$("#numatcard option:selected").each(function () {
				    numatcard = $(this).attr('value');
				});
		    	
		    	if (id == '' || numatcard == '')
		    	{ 
		    		$("#tabla_lineas").html(""); 
		    	}
		    	else{

		    		identificador = $("#identificador").val();
		    		price_list = $("#price_list").val();
		    		cliente = id;
		    		nextinput = 0;
		    		$.post("insertar_lineas.php", {sociedad:identificador,cliente:cliente, numatcard:numatcard, price_list:price_list}, function(datos)
					{
						$("#tabla_lineas").html(datos);
					});
				}
		    	
		    }
		    function Traer_persona_contacto(valor)
		    {
		    	
				$("#cardcode1 option:selected").each(function () {
				    str = $(this).text();
				    id = $(this).attr('value');
				});
		    	
		    	if (id == '')
		    	{ 
		    		$("#persona_contacto_c").html(""); 
		    	}
		    	else{
		    		identificador = $("#identificador").val();
		    		cliente = id;
		    		$.post("insertar_percontacto.php", {sociedad:identificador,cliente:cliente}, function(datos)
					{
						$("#persona_contacto_c").html(datos);
					});
				}
		    }
		    function Traer_numero_referencia(valor)
		    {
		    	
				$("#cardcode1 option:selected").each(function () {
				    str = $(this).text();
				    id = $(this).attr('value');
				});
		    	
		    	if (id == '')
		    	{ 
		    		$("#numero_referencia_c").html(""); 
		    	}
		    	else{
		    		identificador = $("#identificador").val();
		    		cliente = id;
		    		$.post("insertar_numeroref.php", {sociedad:identificador,cliente:cliente}, function(datos)
					{
						$("#numero_referencia_c").html(datos);
					});
				}
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

				$("#textoname"+fila).val(myArray[2]);
				$("#price"+fila).val(myArray[0]);
				$("#currency"+fila).val(myArray[1]);
				$("#moneda"+fila).val(myArray[1]);
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
				$("#moneda"+fila).val(myArray[2]);
				$("#quantity"+fila).val(1);

				valor_total(fila);
				
			}

			function BuscarProyecto(fila, opcion){
				var texto = "";
				var textoid = "";
				

				if (opcion == 1){
					
					$("#project"+fila+" option:selected").each(function () {
				    texto = $(this).attr('value');
				    textoid = $(this).attr('id');
				 	});
					$("#prjname"+fila).val(textoid);
					
				}

				if (opcion == 2){
					$("#prjname"+fila+" option:selected").each(function () {
				    texto = $(this).attr('value');
				    textoid = $(this).attr('id');
				 	});
					$("#project"+fila).val(textoid);
				}
			}

			function validar_cantidad(valor, fila){

				//Compruebo si es un valor numérico
				//valor = valor.replace(",",".");
				//$("#quantity"+fila).val(valor);
			    valor = parseInt(valor)
			    if (valor == 0){

			    }
			    else{
					if (isNaN(valor)) {
				        //entonces (no es numero) devuelvo el valor cadena vacia
				        alert("Ingrese una cantidad valida");
				        $("#quantity"+fila).val(0);
				        //return 0
				    }else{
				        //En caso contrario (Si era un número) devuelvo el valor
				        if (valor <= 0){
				        	alert("Ingrese una cantidad valida");
				        	$("#quantity"+fila).val(0);
				        //return 0
				        }
				        else{
				        	//$("#quantity"+fila).val(valor);
				        	//return valor
				        }
				        	
				    }

			    }
			    

			}


		    function validar(){
		    	
		    	if (document.form.cardcode.value == ''){
		    		alert("Es necesario que ingrese un Cliente");
		    		document.form.cardcode.focus();
		    		return false;
		    	}
		    	if (document.form.cardname.value == ''){
		    		alert("Es necesario que ingrese un Cliente");
		    		document.form.cardname.focus();
		    		return false;
		    	}
		    	if (document.form.numatcard.value == ''){
		    		alert("Es necesario que ingrese un numero de referencia");
		    		document.form.numatcard.focus();
		    		return false;
		    	}
		    	if (document.form.name.value == ''){
		    		alert("Es necesario que ingrese la persona de contacto");
		    		document.form.name.focus();
		    		return false;
		    	}
		    	/*
		    	if (document.form.docdate.value == ''){
		    		alert("Es necesario que ingrese la fecha");
		    		document.form.docdate.focus();
		    		return false;
		    	}
		    	if (document.form.docduedate.value == ''){
		    		alert("Es necesario que ingrese la fecha");
		    		document.form.docduedate.focus();
		    		return false;
		    	}
		    	if (document.form.taxdate.value == ''){
		    		alert("Es necesario que ingrese la fecha");
		    		document.form.taxdate.focus();
		    		return false;
		    	}
		    	*/

		    	if (document.form.pozo.value == ''){
		    		alert("Es necesario que ingrese el pozo");
		    		document.form.pozo.focus();
		    		return false;
		    	}
		    	if (document.form.rephslofs.value == ''){
		    		alert("Es necesario que ingrese el Representante HSLOFS");
		    		document.form.rephslofs.focus();
		    		return false;
		    	}
		    	if (document.form.repcliente1.value == ''){
		    		alert("Es necesario que ingrese el Representante Cliente");
		    		document.form.repcliente1.focus();
		    		return false;
		    	}
		    	if (document.form.repcliente2.value == ''){
		    		alert("Es necesario que ingrese el Representante Cliente");
		    		document.form.repcliente2.focus();
		    		return false;
		    	}

		    	//Las Lineas
		    	
		    	if (document.form.itemcode0.value == '')
		    	{
		    		alert("Es necesario que ingrese un Articulo");
		    		return false;
		    	}


				
		    	var texto = "";
				var textoid = "";
				var fila = 0;
				while(fila <= nextinput){
					 $("#itemcode"+fila+" option:selected").each(function () {
					    texto = $(this).attr('value');
					    textoid = $(this).attr('id');
					 });

					 if(texto == ''){}
					 else{
					 	$("#itemname"+fila+" option:selected").each(function () {
							    texto = $(this).attr('value');
						});
					 	if(texto == ''){
							alert("Ingrese los campos Obligatorios en las lineas");
							return false;
						}
						/*
						texto = $("#numdia"+fila).val();
					 	if(texto == ''){
							alert("Ingrese los campos Obligatorios en las lineas");
							$("#numdia"+fila).focus();
							return false;
						}
						*/

						texto = $("#quantity"+fila).val();
					 	if(texto == ''){
							alert("Ingrese los campos Obligatorios en las lineas");
							$("#quantity"+fila).focus();
							return false;
						}

						texto = $("#price"+fila).val();
					 	if(texto == ''){
							alert("Ingrese los campos Obligatorios en las lineas");
							$("#price"+fila).focus();
							return false;
						}
						if(texto == '0'){
							alert("El valor del precio debe ser mayor que cero (0)");
							$("#price"+fila).focus();
							return false;
						}

						texto = $("#linetotal"+fila).val();
					 	if(texto == ''){
							alert("Ingrese los campos Obligatorios en las lineas");
							$("#linetotal"+fila).focus();
							return false;
						}
						if(texto == '0'){
							alert("El valor del Total ML debe ser mayor que cero (0)");
							$("#linetotal"+fila).focus();
							return false;
						}

						$("#project"+fila+" option:selected").each(function () {
							    texto = $(this).attr('value');
						});
					 	if(texto == ''){
							alert("Ingrese los campos Obligatorios en las lineas");
							$("#project"+fila).focus();
							return false;
						}
						/*
						texto = $("#prjname"+fila).val();
					 	if(texto == ''){
							alert("Ingrese los campos Obligatorios en las lineas");
							$("#prjname"+fila).focus();
							return false;
						}
						*/

						$("#paracontoper"+fila+" option:selected").each(function () {
							    texto = $(this).attr('value');
						});
					 	if(texto == ''){
							alert("Ingrese los campos Obligatorios en las lineas");
							$("#paracontoper"+fila).focus();
							return false;
						}

						$("#tipooperacion"+fila+" option:selected").each(function () {
							    texto = $(this).attr('value');
						});
					 	if(texto == ''){
							alert("Ingrese los campos Obligatorios en las lineas");
							$("#tipooperacion"+fila).focus();
							return false;
						}

						$("#pozolinea"+fila+" option:selected").each(function () {
							    texto = $(this).attr('value');
						});
					 	if(texto == ''){
							alert("Ingrese los campos Obligatorios en las lineas");
							$("#pozolinea"+fila).focus();
							return false;
						}

						texto = $("#freetxt"+fila).val();
					 	if(texto == ''){
							alert("Ingrese los campos Obligatorios en las lineas");
							$("#freetxt"+fila).focus();
							return false;
						}

						texto = $("#dtllservicio"+fila).val();
					 	if(texto == ''){
							alert("Ingrese los campos Obligatorios en las lineas");
							$("#dtllservicio"+fila).focus();
							return false;
						}

						/*
						texto = $("#anexo"+fila).val();
					 	if(texto == ''){
							alert("Ingrese los campos Obligatorios en las lineas");
							$("#anexo"+fila).focus();
							return false;
						}
						*/
					}

					fila = fila + 1;
				}
				
				
		    	if (confirm("Esta Seguro(a) de continuar?"))
				{
					$("#cargando_datos").html("<div align=left><font color=red face=arial size=3>&nbsp; &nbsp; Los datos están siendo cargados en la base, el tiempo de espera depender&aacute; de la cantidad de datos ingresados. ...</font></div>");
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
		    	$("#totaldocext").val(valor_documentoext(40));
		    	//valor_comision(linea);
		    	getnumerodedias(linea);

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
				var moneda;
				
				for (var i = 0; i < nextinput +1 ; i++) {
					valor = $("#linetotal"+i).val();
					if ( valor == '')
					{}
					else{
						moneda = $("#moneda"+i).val();
						if (moneda == '$')
						{
							totaldoc = parseFloat(totaldoc) + parseFloat(valor);		
						}
						
					}
				};
				//alert(totaldoc);
				return totaldoc;
			}
			function valor_documentoext(lineas)
			{
				
				var totaldoc = 0;
				var valor;
				var moneda;
				
				for (var i = 0; i < nextinput +1 ; i++) {
					valor = $("#linetotal"+i).val();
					//if (!/^([0-9])*$/.test(valor) || valor == '')
					if ( valor == '')
					{}
					else{
						moneda = $("#moneda"+i).val();
						if (moneda == 'USD')
						{
							//totaldoc = totaldoc + parseInt(valor);
							totaldoc = parseFloat(totaldoc) + parseFloat(valor);
						}
					}
				};
				//alert(totaldoc);
				return totaldoc;
			}
			function valor_total_comision(lineas)
			{
				
				var totalcomision = 0;
				var valor;
				
				for (var i = 0; i <= nextinput +1 ; i++) {
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

	</script>

<script language="JavaScript" type="text/javascript">

window.addEvent('unload', PageLoad);
</script>

<script type="text/javascript">
//var nextinput = 0;
var fila;
	function AgregarCampos(){
		nextinput++;

		alert(nextinput);
		campo = '<tr><td>'+nextinput+'</td><td><?php echo "Esto saldra" ?></td></tr>';
		$("#campos").append(campo);
	}

function AgregarRegistro(Lay){
	nextinput++;
	$("#linea_registro"+nextinput).html("<div align=left><font face=arial size=2>Cargando datos ...</font></div>");
	$("#cardcode1 option:selected").each(function () {
		    str = $(this).text();
		    id = $(this).attr('value');
		});

		$("#numatcard option:selected").each(function () {
		    numatcard = $(this).attr('value');
		});
    	
    	if (id == '' || numatcard == '')
    	{ 
    		$("#tabla_lineas").html(""); 
    	}
    	else{

    		identificador = $("#identificador").val();
    		price_list = $("#price_list").val();
    		cliente = id;
    		fila = nextinput;
    		
    		$.post("insertar_lineas_add.php", {fila:fila,sociedad:identificador,cliente:cliente, numatcard:numatcard, price_list:price_list}, function(datos)
			{
				$("#linea_registro"+nextinput).html(datos);
			});
	}

	/*
	Lay = Lay + nextinput; 
	$("#"+Lay).css("display", "");
	*/

}

function getnumerodedias(filalinea){
	
var fecha1= $('#fc_100200'+filalinea).val();
var anyo1= fecha1.substr(0,4);
var mes1= fecha1.substr(5,2);
var dia1= fecha1.substr(8);

var fecha2= $('#fc_200200'+filalinea).val();
var anyo2= fecha2.substr(0,4);
var mes2= fecha2.substr(5,2);
var dia2= fecha2.substr(8);

var nuevafecha1= new Date(anyo1+","+mes1+","+dia1);
var nuevafecha2= new Date(anyo2+","+mes2+","+dia2);

var Dif= nuevafecha2.getTime() - nuevafecha1.getTime();
var dias= Math.floor(Dif/(1000*24*60*60));
$("#numdia"+filalinea).val(dias);
//alert(dias);
	
}

function gettasedecambio(){
	alert('La tase de cambio');
}

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
<body >
	<?php
	if (isset($_SESSION["sudlogin"]))
	{
	?>

	<div id="cont_form">
	<form action="" method="post" name="formsoc" onsubmit="return validar()" > <!--  -->
		<label>Sociedad</label>
		<select id="selector" name="sociedad" onChange="javascript:submit()" style="width:200px;"> 
		<option value="" ></option>
		<?php
		///INICIO DEL CUERPO DEL MENU ***************
		$sql = "SELECT j0.idsoc, j0.cmpname, j0.identificador, j0.id_integra
				FROM srgc as j0
				Inner Join companiasxperfiles as j1 on j0.idsoc = j1.idcia
				WHERE j0.activo = 'Y'
				And j1.idperfil = '".$_SESSION["sudperfil"]."'";
		
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
	
	$sql  = "SELECT campoextra1, login, price_list FROM usuarios ";
	$sql .= " Where login = '".$_SESSION['sudlogin'] ."'";
	
	$result = mysql_query($sql,$link) or die(mysql_error());
	if ($row_c = mysql_fetch_assoc($result))
	{
		$campoextra1 = $row_c[campoextra1];
		$price_list = $row_c[price_list];
	}

	$sql  = "SELECT cardcode, cardname FROM ocrd ";
	$sql .= " Where id_integra = '$identificador' And estado = 'A' and groupcode = '100'";
	$sql .= " Order by cardname";
	
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$cliente[] = $row[cardcode];
		$namecliente[] = $row[cardname];
	}

	$sql  = "SELECT code, name FROM pozoline ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by name";
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$pozo[] = $row[code];
		$namepozo[] = $row[name];
	}

	$sql  = "SELECT  name FROM empleado ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by name";
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$empleado[] = $row[name];
	}

	$sql  = "SELECT code, name FROM oprj ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by code";
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$proyecto[] = $row[code];
		$nameproyecto[] = $row[name];
	}

	$sql  = "SELECT code, name FROM rephslofs ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by name";
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$ohemcode[] = $row[code];
		$ohemname[] = $row[name];
	}

	$sql  = "SELECT code, name FROM unidad ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by name";
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$unidadcode[] = $row[code];
		$unidadname[] = $row[name];
	}

	$sql  = "SELECT code, name FROM operacion ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by name";
	$result = mysql_query($sql,$link) or die(mysql_error());
	
	while($row = mysql_fetch_assoc($result))
	{
		$operacioncode[] = $row[code];  //str_replace("Ñ", "N", $row[code]);
		$operacionname[] = $row[name];  //str_replace("Ñ", "N", $row[name]);
	}

	$sql  = "SELECT fldvalue, descr FROM contoper ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by descr";
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$conteo_operaciones[] = $row[descr];
	}

	$sql  = "SELECT code, name FROM quienllama ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by name";
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$quienllamacode[] = $row[code];
		$quienllamaname[] = $row[name];
	}

	$sql  = "SELECT code, name FROM ucampo ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by name";
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$ucampocode[] = $row[code];
		$ucamponame[] = $row[name];
	}


	?>
	<span id="obligatorio">(*)</span> campos obligatorios
	<?php
	if ($identificador <> ''){
		?>
		<div id="pedido">
		<table class="tabla_pedido">
			<tr>
				<td class="subtitulo">
				Orden de Venta
				
				</td>
			</tr>
			<tr>
				<td>
					
				<form name="form" id="formulario" action="" method="post" onsubmit="return validar();"  enctype=multipart/form-data /> <!--  -->
					<input type="hidden" name="identificador" id="identificador" value="<?= $identificador; ?>" />
					<input type="hidden" name="price_list" id="price_list" value="<?= $price_list; ?>" />
					
					<!--  INICIO CABECERA  -->
					<table>
						<tr>
							<td id="label1">
								Cliente <span id="obligatorio">(*)</span>
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
							<td id="label1">
								Fecha de Contabilizaci&oacute;n:  <span id="obligatorio">(*)</span>
							</td>
							<td id="campo1">
								
								<input size="14" id="fc_1295035967" type="text" 
								 READONLY name="docdate1" title="yyyy-mm-dd" value="<?= date('Y-m-d'); ?>" /> 
								<a href="javascript:displayCalendarFor('fc_1295035967');"><img src="<?php echo $gloRutaPublica . "/imagenes/b_calendar.jpg"; ?>" border="0"></a>
							</td>

						</tr>
						<tr>
							<td id="label1">
								Nombre Cliente  <span id="obligatorio">(*)</span>
							</td>
							<td id="campo1">
								<select name="cardname" id="cardname1" style="width:300px;" onchange="BuscarCli(2);">
								<option></option>
									<?php 
										foreach ($cliente as $key => $value) {
										    echo "<option value=\"$value\" id=\"$namecliente[$key]\">".$namecliente[$key]."</option>\n";  
										}
									?>
								</select>
							</td>
							<td id="label1">
								Fecha de Entrega:  <span id="obligatorio">(*)</span>
							</td>
							<td id="campo1">
								
								<input size="14" id="fc_1295035968" type="text" size="20" 
								READONLY name="docduedate" title="yyyy-mm-dd" value="<?= date('Y-m-d'); ?>" /> 
								<a href="javascript:displayCalendarFor('fc_1295035968');"><img src="<?php echo $gloRutaPublica . "/imagenes/b_calendar.jpg"; ?>" border="0"></a>
							</td>
						</tr>

						<tr>
							<td id="label1">
								N&uacute;mero de Referencia:  <span id="obligatorio">(*)</span>
							</td>
							<td id="campo1">
								<span id="numero_referencia_c">
								</span>
							</td>
							<td id="label1">
								Fecha de Documento:  <span id="obligatorio">(*)</span>
							</td>
							<td id="campo1">
								
								<input size="14" id="fc_1295035969" type="text" size="20" 
								 name="taxdate" title="yyyy-mm-dd" value="<?= date('Y-m-d'); ?>"/> 
								<a href="javascript:displayCalendarFor('fc_1295035969');" ><img src="<?php echo $gloRutaPublica . "/imagenes/b_calendar.jpg"; ?>" border="0"></a>
							</td>
						</tr>
						
						<tr>
							<td id="label1">
								Persona de contacto:  <span id="obligatorio">(*)</span>
							</td>
							<td id="campo1">
								<span id="persona_contacto_c">
								</span>
							</td>
							<td id="label1">
								Pozo:  <span id="obligatorio">(*)</span>
							</td>
							<td id="campo1">
								<select name="pozo" id="pozo" style="width:200px;" >
								<option></option>
									<?php 
										foreach ($pozo as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">". $namepozo[$key]."</option>\n";  
										}
									?>
								</select>
							</td>
						</tr>
						
						<tr>
							<td id="label1">
								Representante HSLOFS:  <span id="obligatorio">(*)</span>
							</td>
							<td id="campo1">
								<select name="rephslofs" id="rephslofs" style="width:250px;" >
								<option></option>
									<?php 
										foreach ($ohemcode as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">".$ohemname[$key]."</option>\n";  
										}
									?>
								</select>
							</td>
							<td id="label1">
								Representante del Cliente:  <span id="obligatorio">(*)</span>
							</td>
							<td id="campo1" id="label1_u">
								Nombres &nbsp;
								<input type="text" name="repcliente1" maxlength="50" size="35" />
								&nbsp;
								Apellidos &nbsp;
								<input type="text" name="repcliente2" maxlength="50" size="35" />
							</td>
						</tr>

						<tr>
							<td id="label1">
								N&uacute;mero Tiquete F&iacute;sico:
							</td>
							<td id="campo1">
								<input type="text" name="tiquete_fisico" maxlength="200" size="60" />
							</td>
							<td id="label1">
								Quien Llama:
							</td>
							<td id="campo1">
								<select name="quienllama" id="quienllama" style="width:200px;" >
								<option></option>
									<?php 
										foreach ($quienllamacode as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">".$quienllamaname[$key]."</option>\n";  
										}
									?>
								</select>
								<br><div id="label1_u"> Sugerido &nbsp; <input type="text" name="sugerido" size="35"></div>
							</td>
						</tr>

						<tr>
							<td id="label1">
								Unidad
							</td>
							<td id="campo1">
								<select name="unidad" id="unidad" style="width:250px;" >
								<option></option>
									<?php 
										foreach ($unidadcode as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">".$unidadname[$key]."</option>\n";  
										}
									?>
								</select>
							</td>
							<td id="label1">
								Operaci&oacute;n
							</td>
							<td id="campo1">
								<select name="operacion" id="operacion" style="width:250px;" >
								<option></option>
									<?php 
										foreach ($operacioncode as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">".$operacionname[$key]."</option>\n";  
										}
									?>
								</select>
							</td>
						</tr>

						<tr>
							<td id="label1">
								Campo
							</td>
							<td id="campo1">
								<select name="campo" id="campo" style="width:250px;" >
								<option></option>
									<?php 
										foreach ($ucampocode as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">".$ucamponame[$key]."</option>\n";  
										}
									?>
								</select>
							</td>
							<td id="label1">
							</td>
							<td id="campo1">
								
							</td>
						</tr>

						<tr>
							<td id="label1_u" colspan="2" align="center">
								Calidad &nbsp;
								<select name="ucalidad" style="width:50px">
									<option value=""></option>
									<option value="S">Si</option>
									<option value="N">No</option>
								</select>
								&nbsp;
								Cumplimiento &nbsp;
								<select name="ucumplimiento" style="width:50px">
									<option value=""></option>
									<option value="S">Si</option>
									<option value="N">No</option>
								</select>
								&nbsp;
								Ejecución de Trabajo &nbsp;
								<select name="uejecucionw" style="width:50px">
									<option value=""></option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>

							</td>
							<td id="label1_u" colspan="2" align="center">
								Equipo &nbsp;
								<select name="uequipo" style="width:50px">
									<option value=""></option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
								&nbsp;
								SISO &nbsp;
								<select name="usiso" style="width:50px">
									<option value=""></option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
								&nbsp;
								Medio Ambiente &nbsp;
								<select name="umedioa" style="width:50px">
									<option value=""></option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
							</td>
							
						</tr>

					</table>
					<!--  FIN CABECERA  -->
					<br/>
					<div id="cargando" >
					</div>
					<!-- INICIO DE LINEAS  -->
					<div class="tabla_lineas" id="tabla_lineas">
					</div>	
					<!-- FIN LINEAS  -->
				</td>
			</tr>
			<tr>
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
			</tr>
			<tr>
				<td width="80%">
					
					<input type="hidden" name="identificador" value="<?= $identificador; ?>" />
					<input class="boton_submit" type="submit" value="Crear" />
					&nbsp; &nbsp; &nbsp;
					<input class="boton_submit" type="button" value="Cancelar" onclick="javascript:location.href='<?= $_SERVER['HTTP_REFERER']; ?>';" />
					&nbsp; &nbsp; &nbsp;
						Total Documento &nbsp; $
						<input class="campo_texto" type="text" id="totaldoc" size="12" readonly />
						&nbsp; &nbsp; USD
						<input class="campo_texto" type="text" id="totaldocext" size="12" readonly />
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