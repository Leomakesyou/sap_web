<?php session_start();
 require_once('conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 include ("conexion/Conect_DB.php");
$ArchivoCalendar = "javascript/calendar_1.php";
include ($ArchivoCalendar);
$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);
$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());

$identificador	 = $_POST['sociedad'];
$cliente_actual	 = $_POST['cliente'];
$price_list		 = $_POST['price_list'];
$numatcard		 = $_POST['numatcard']; 
	
	/*
	$sql  = "SELECT j0.itemcode, j0.itemname, j1.pricelist, j1.price, j1.currency 
			 FROM oitm as j0
			 Inner Join itm1 as j1 on j0.itemcode = j1.itemcode	";
	$sql .= " Where j0.id_integra = '$identificador' And j1.pricelist = '$price_list'";
	$sql .= " Order By j0.itemname";
	*/
	$sql  = "SELECT j0.itemcode, j1.itemname, j0.currency, j0.price, j0.id_integra From precios as j0 ";
	$sql .= " Inner Join oitm as j1 on j0.itemcode = j1.itemcode ";
	$sql .= " Where j0.cardcode = '$cliente_actual' and j0.id_integra = '$identificador'"; 
	$sql .= " And j0.numatcard = '$numatcard'";
	//echo "sql: ".$sql;
	$result = mysql_query($sql,$link) or die(mysql_error());
	$i = 0;
	while($row = mysql_fetch_assoc($result))
	{
		$item[$i] = $row[itemcode];
		$nameitem[$i] = $row[itemname];
		$precio[$i] = $row[price];
		$moneda[$i] = $row[currency];
		$i ++;
	}
	
	$sql  = "SELECT code, name FROM pozoline ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by name";
	//echo "<br>Consulta: ".$sql;
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$pozo[] = $row[code];
		$namepozo[] = $row[name];
	}

	$sql  = "SELECT  name FROM empleado ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by name";
	//echo "<br>Consulta: ".$sql;
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$empleado[] = $row[name];
	}

	$sql  = "SELECT code, name FROM oprj ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by name";
	//echo "<br>Consulta: ".$sql;
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$proyecto[] = $row[code];
		$nameproyecto[] = $row[name];
	}

	$sql  = "SELECT fldvalue, descr FROM contoper ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by descr";
	//echo "<br>Consulta: ".$sql;
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$conteo_operaciones[] = $row[descr];
	}

	$sql  = "SELECT code, name FROM tipooper ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by name";
	//echo "<br>Consulta: ".$sql;
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$tipo_operacion[] = $row[name];
	}

	$sql  = "SELECT fldvalue, descr FROM porcempl ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by descr";
	//echo "<br>Consulta: ".$sql;
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$porce_emp[] = $row[fldvalue];
		$porce_desc[] = $row[descr];
	}

	$sql  = "SELECT fldvalue, descr FROM alimempl ";
	$sql .= " Where id_integra = '$identificador'";
	$sql .= " Order by descr";
	
	$result = mysql_query($sql,$link) or die(mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		$ali_emp[] = $row[fldvalue];
		$ali_desc[] = $row[descr];
	}
	
	$sql  = "SELECT cardcode, cardname FROM ocrd ";
	$sql .= " Where id_integra = '$identificador' and estado = 'A'";
	$sql .= " Order by cardname";
	
	$result = mysql_query($sql,$link) or die(mysql_error());
	$i = 1;
	while($row = mysql_fetch_assoc($result))
	{
		$cliente[$i] = $row[cardcode];
		$namecliente[$i] = $row[cardname];
		$i = $i + 1;
	}

?>
			<table border=0 >
				<tr id="titulo_estatico">
					<td class="titulo_matriz" width="18px">
					#
					</td>
					<td class="titulo_matriz" width="150px">
						N&uacute;mero Art&iacute;culo <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="250px">
						Descripci&oacute;n de Art&iacute;culo <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="150px">
						Fecha Inicial <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="150px">
						Fecha Final <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="149px">
						No D&iacute;as <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="149px">
						Cantidad <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="149px">
						Precio unitario <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="150px">
						Total ML <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="150px">
						Proyecto <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="150px">
						Nombre Proyecto <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="150px">
						Conteo Operaciones <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="150px">
						Tipo de Operaci&oacute;n <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="150px">
						Pozo L&iacute;nea <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="150px">
						Indicador de Impuestos
					</td>
					<td class="titulo_matriz" width="150px">
						No Orden Trabajo
					</td>
					<td class="titulo_matriz" width="150px">
						Texto Libre <span id="obligatorio">(*)</span>
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
						Detalle Servicio <span id="obligatorio">(*)</span>
					</td>
					<td class="titulo_matriz" width="150px">
						Detalles de Art&iacute;culo
					</td>
					<td class="titulo_matriz" width="150px">
						No de L&iacute;nea
					</td>
					<td class="titulo_matriz" width="150px">
						No Tiquete
					</td>
					<td class="titulo_matriz" width="150px">
						Documento base
					</td>
					<td class="titulo_matriz" width="250px">
						Adjuntos <span id="obligatorio">(*)</span>
					</td>

				</tr>
				
				<tr>
				<td colspan="100">
				<div class="tabla_detalle">
				<table border=0 >

				<?php
				$fila = 0;
				while($fila < 5)
				{	

					if ($fila > 5)
					{ ?>
					<tr id="registro<?= $fila ;?>" style="display:none">
				<?php	}
					else
						{ ?>
					<tr id="registro<?= $fila ;?>">
				<?php	}
				?>
						<td align="center" class="matriz_campo" style="width:20px;">
						<?= $fila + 1; ?>
						</td>
						<td class="matriz_campo" >
							<select name="itemcode[]" id="itemcode<?= $fila; ?>" style="width:140px;" 
							onchange="BuscarItem(<?= $fila; ?>, 1);">
							<option></option>
								<?php 
									foreach ($item as $key => $value) {
//echo "<option value=\"$value\" id=\"$nameitem[$key];$precio[$key];$moneda[$key]\">".$key."-".$value." - ".$nameitem[$key]." - ".$precio[$key]."</option>\n";  
									?>
<option value="<?= $value; ?>" id="<?= $precio[$key].';'.$moneda[$key].';'.$nameitem[$key]; ?>"><?= $value; ?>	 </option>									
								<?php	
									}
								?>
							</select>
						</td>
						<td class="matriz_campo" style="width:255px;">
							<select name="itemname[]" id="itemname<?= $fila; ?>" style="width:250px;" 
							onchange="BuscarItem(<?= $fila; ?>, 2);">
							<option></option>
								<?php 
									foreach ($item as $key => $value) {
//echo "<option value=\"$value\" id=\"$nameitem[$key];$precio[$key];$moneda[$key]\">".$nameitem[$key]."</option>\n";  
									?>
<option value="<?= $value; ?>" id="<?= $precio[$key].';'.$moneda[$key].';'.$nameitem[$key]; ?>"><?= $nameitem[$key]; ?>	 </option>											
								<?php
									}
								?>
							</select>
						</td>
						
						<td class="matriz_campo" style="width:155px;">
							<input size="14" id="<?= "fc_100200".$fila; ?>" type="text" 
							READONLY name="fechaini[]" title="yyyy-mm-dd" value="<?= date('Y-m-d'); ?>" /> 
							<a href="javascript:displayCalendarFor('fc_100200'+<?= $fila ?>);"><img src="<?php echo $gloRutaPublica . "/imagenes/b_calendar.jpg"; ?>" border="0"></a>
						</td>
						<td class="matriz_campo" style="width:155px;">
							<input size="14" id="<?= "fc_200200".$fila; ?>" type="text" 
							READONLY name="fechafin[]" title="yyyy-mm-dd" value="<?= date('Y-m-d'); ?>" /> 
							<a href="javascript:displayCalendarFor('fc_200200'+<?= $fila ?>);"><img src="<?php echo $gloRutaPublica . "/imagenes/b_calendar.jpg"; ?>" border="0"></a>
						</td>
						<td class="matriz_campo" >
							<input type="hidden" id="<?= "currency".$fila; ?>" size="2" />
							<input type="number" name="numdia[]" id="<?= "numdia".$fila; ?>" size="10" /> 
							
						</td>
						<td class="matriz_campo" >
							<input type="number" name="quantity[]" id="<?= "quantity".$fila; ?>" size="10"
							onchange="valor_total('<?= $fila; ?>');" onBlur="return validar_cantidad(this.value,<?= $fila ?>)" />
						</td>
						
							
						<td class="matriz_campo" >
							<input type="number" name="price[]" id="<?= "price".$fila; ?>" size="10" 
							onchange="valor_total('<?= $fila; ?>');" />
						</td>
						
						<td class="matriz_campo" >
							<input type="number" name="linetotal[]" id="<?= "linetotal".$fila; ?>" size="12" readonly />
						</td>
						<td class="matriz_campo" >
							<select name="project[]" id="<?= "project".$fila; ?>" style="width:150px;"
							onchange="BuscarProyecto(<?= $fila; ?>);" >
								<option></option>
									<?php 
										foreach ($proyecto as $key => $value) {
									?>
										    <option value="<?= $value ?>" id="<?= $nameproyecto[$key] ?>"><?=  $value." - ".$nameproyecto[$key]; ?></option>  
									<?php
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<input type="text" name="prjname[]" id="<?= "prjname".$fila; ?>" size="20" maxlength="200" />
						</td>
						<td class="matriz_campo" >
							<select name="paracontoper[]" id="<?= "paracontoper".$fila; ?>" style="width:150px;" >
								<option></option>
									<?php 
										foreach ($conteo_operaciones as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$value."</option>\n";  
										}
									?>
							</select>
							
						</td>
						<td class="matriz_campo" >
							<select name="tipooperacion[]" id="<?= "tipooperacion".$fila; ?>" style="width:151px;" >
								<option></option>
									<?php 
										foreach ($tipo_operacion as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$value."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="pozolinea[]" id="<?= "pozolinea".$fila; ?>" style="width:151px;" >
							<option></option>
								<?php 
									foreach ($pozo as $key => $value) {
									    echo "<option value=\"$value\" id=\"$value\">".$value." - " .$value."</option>\n";  
									}
								?>
							</select>
							
						</td>
						<td class="matriz_campo" >
							<input type="text" name="taxcode[]" id="<?= "taxcode".$fila; ?>" size="12" maxlength="16" />
						</td>
						<td class="matriz_campo" >
							<input type="text" name="ordentrabajo[]" id="<?= "ordentrabajo".$fila; ?>" size="12" maxlength="200" />
						</td>
						<td class="matriz_campo" >
							<input type="text" name="freetxt[]" id="<?= "freetxt".$fila; ?>" size="12" maxlength="80" />
						</td>
						<td class="matriz_campo" >
							<select name="empleado1[]" id="<?= "empelado1".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($empleado as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$value."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="poremp1[]" id="<?= "poremp1".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($porce_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$porce_desc[$key]."</option>\n";  
										}
									?>
							</select>
							
						</td>
						<td class="matriz_campo" >
							<select name="aliemp1[]" id="<?= "aliemp1".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($ali_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$ali_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="empleado2[]" id="<?= "empelado2".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($empleado as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$value."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="poremp2[]" id="<?= "poremp2".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($porce_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$porce_desc[$key]."</option>\n";  
										}
									?>
							</select>
							
						</td>
						<td class="matriz_campo" >
							<select name="aliemp2[]" id="<?= "aliemp2".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($ali_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$ali_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="empleado3[]" id="<?= "empelado3".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($empleado as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$value."</option>\n";  
										}
									?>
							</select>
							
						</td>
						<td class="matriz_campo" >
							<select name="poremp3[]" id="<?= "poremp3".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($porce_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$porce_desc[$key]."</option>\n";  
										}
									?>
							</select>
							
						</td>
						<td class="matriz_campo" >
							<select name="aliemp3[]" id="<?= "aliemp3".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($ali_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$ali_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="empleado4[]" id="<?= "empelado4".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($empleado as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$value."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="poremp4[]" id="<?= "poremp4".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($porce_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$porce_desc[$key]."</option>\n";  
										}
									?>
							</select>
							
						</td>
						<td class="matriz_campo" >
							<select name="aliemp4[]" id="<?= "aliemp4".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($ali_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$ali_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="empleado5[]" id="<?= "empelado5".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($empleado as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$value."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="poremp5[]" id="<?= "poremp5".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($porce_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$porce_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="aliemp5[]" id="<?= "aliemp5".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($ali_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$ali_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="empleado6[]" id="<?= "empelado6".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($empleado as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$value."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="poremp6[]" id="<?= "poremp6".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($porce_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$porce_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="aliemp6[]" id="<?= "aliemp6".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($ali_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$ali_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="empleado7[]" id="<?= "empelado7".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($empleado as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$value."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="poremp7[]" id="<?= "poremp7".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($porce_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$porce_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="aliemp7[]" id="<?= "aliemp7".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($ali_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$ali_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="empleado8[]" id="<?= "empelado8".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($empleado as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$value."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="poremp8[]" id="<?= "poremp8".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($porce_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$porce_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="aliemp8[]" id="<?= "aliemp8".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($ali_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$ali_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="empleado9[]" id="<?= "empelado9".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($empleado as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$value."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="poremp9[]" id="<?= "poremp9".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($porce_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$porce_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="aliemp9[]" id="<?= "aliemp9".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($ali_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$ali_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="empleado10[]" id="<?= "empelado10".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($empleado as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$value."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="poremp10[]" id="<?= "poremp10".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($porce_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$porce_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<select name="aliemp10[]" id="<?= "aliemp10".$fila; ?>" style="width:120px;" >
								<option></option>
									<?php 
										foreach ($ali_emp as $key => $value) {
										    echo "<option value=\"$value\" id=\"$value\">" .$ali_desc[$key]."</option>\n";  
										}
									?>
							</select>
						</td>
						<td class="matriz_campo" >
							<input type="text" name="discprcnt[]" id="<?= "discprcnt".$fila; ?>" size="12" maxlength="27" />
						</td>
						<td class="matriz_campo" >
							<input type="text" name="porcdescecop[]" id="<?= "porcdescecop".$fila; ?>" size="12" maxlength="20" />
						</td>
						<td class="matriz_campo" >
							<input type="text" name="dtllservicio[]" id="<?= "dtllservicio".$fila; ?>" size="12" maxlength="20" />
						</td>
						<td class="matriz_campo" >
							<input type="text" name="text[]" id="<?= "text".$fila; ?>" size="12" maxlength="16" />
						</td>
						
						<td class="matriz_campo" >
							<input type="text" name="linea[]" id="<?= "linea".$fila; ?>" size="12" maxlength="2" />
						</td>
						<td class="matriz_campo" >
							<input type="text" name="tiquete[]" id="<?= "tiquete".$fila; ?>" size="12" maxlength="200" />
						</td>
						<td class="matriz_campo" >
							<input type="text" name="docubase[]" id="<?= "docubase".$fila; ?>" size="12" maxlength="200" />
						</td>
						<td class="matriz_campo" style="width:250px;">
							<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
							<input name="anexo[]" id="<?= "anexo".$fila; ?>" type="file" />
						</td>


					</tr>
				<?php
				$fila = $fila + 1;
				 } //fin del while
				?>
				<tr>
					<td colspan="100">
						<input type="button" value="+1" name="add_reg" onclick="AgregarRegistro('registro');"
						style="cursor:pointer; width:40px" />
					</td>
				</tr>
				</table>
				</div>
				</td>
				</tr>
			</table>
