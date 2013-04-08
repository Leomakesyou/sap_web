<?php session_start();

 header("Cache-control: no-cache");
 require_once('conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 include ("conexion/Conect_DB.php");  
$ArchivoCalendar = "javascript/calendar_1.php";
include ($ArchivoCalendar);

$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);

?>
<!DOCTYPE html>
<html>
<head>

	<title>Consultar Datos</title>
	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
	<link href="<?php echo $gloRutaPublica . "/estilos_sap.css"; ?>" type=text/css rel=stylesheet>
	<link href="<?php echo $gloRutaPublica . "/estilos/ui.jqgrid.css"; ?>" type=text/css rel=stylesheet>
	<link href="<?php echo $gloRutaPublica . "/estilos/calendar-system.css"; ?>" rel="stylesheet" type="text/css" media="all">
	<Script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/Utilities.js"; ?>"></script>
	<!-- programa principal del calendario -->
	<Script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/calendar.js"; ?>"></script>	
  	<!-- lenguaje del calendario -->
	<Script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/lang/calendar-es.js"; ?>"></script>		
  	<!-- libreria para personalizar el calendario -->
	<Script language="JavaScript" type="text/JavaScript" src="<?php echo $gloRutaPublica . "/javascript/calendar-setup.js"; ?>"></script>
    <script language="javascript" src="/javascript/scripts.js"></script>
	<script src="jquery.js"></script>
	<script type="text/javascript">

	jQuery("#list3").jqGrid({
	   	url:'server.php?q=2',
		datatype: "json",
	   	colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
	   	colModel:[
	   		{name:'id',index:'id', width:60, sorttype:"int"},
	   		{name:'invdate',index:'invdate', width:90, sorttype:"date"},
	   		{name:'name',index:'name', width:100},
	   		{name:'amount',index:'amount', width:80, align:"right",sorttype:"float"},
	   		{name:'tax',index:'tax', width:80, align:"right",sorttype:"float"},		
	   		{name:'total',index:'total', width:80,align:"right",sorttype:"float"},		
	   		{name:'note',index:'note', width:150, sortable:false}		
	   	],
	   	rowNum:20,
	   	rowList:[10,20,30],
	   	pager: '#pager3',
	   	sortname: 'id',
	    viewrecords: true,
	    sortorder: "desc",
	    loadonce: true,
	    caption: "Load Once Example"
	});

	</script>

	<style>
		legend{
			font-family: arial, Helvetica;
			font-size: 14px;
			margin: 2px;
			padding: 2px;
		}
		tfoot{
			font-family: Helvetica, arial;
			font-size: 12px;
			margin: 1px;	
			padding: 2px;
		}
		.tabla_s1 {
			border: solid 1px;
			border-color: #83B3D8;
			border-collapse:collapse;
		}
		.tabla_s1 td{
			border: solid 1px;
			border-color: #83B3D8;	
		}
		.tabla_s1_td_t1 {
			background-color: #EAF4FD;
			color: #2E6EC4;
		}
		.tabla_s1_td_c1{
			color: #000;
			font-family: Helvetica, Arial;
			font-size: 11px;
		}
		#formulario
			{
				background: #fff;
				border-color: #1C3E95;
				border-style: solid;
				border-radius: 0.2em;
				box-shadow: rgba(0,10,44,0.3) 0px 4px 15px;
				color: #000;
				display: block;
				font-size: 1.1em;
				margin: 0.1em auto;
				opacity: 0.8;
				padding: 0.2em;
				position: embebed;
				width: 60%;
				behavior: url(PIE.htc);
			}

			
			#formulario select
			{
				background-color: #AACCCB;
				border: #000;
				/*border-radius: 0.5em;
				-webkit-border-radius: 0.5em;
				-moz-border-radius: 0.5em;
				-o-border-radius: 0.5em;
				-ms-border-radius: 0.5em;
				*/
				box-shadow: rgba(0,10,44,0.3) 0px 2px 5px;
				display: inline-block;
				font-size: 16px;
				margin: 0.4em auto;
				padding: 0.1em;
				width: 62%;
				behavior: url(PIE.htc);
			}
			#formulario option
			{
				font-family: "Arial";
				font-size: 16px;
				font-weight: bold;
				margin: 2px;
				
			}
			#formulario input
			{
				background-color: #AACCCB;
				border-color: #000;
				border-style: solid;
				border-radius: 0.2em;
				color: #000;
				font-family: Helvetica, Arial;
				font-size: 12px;
				margin: 2px;
				padding: 2px;
			}

			#formulario input[type="submit"]
			{
				background: #ffa;
				border-color: #000;
				border-radius: 0.2em;
				box-shadow: rgba(0,0,0,0.7) 2px 2px 10px;
				color: black;
				cursor: pointer;
				font-size: 13px;
				font-style: italic;
				font-weight: bold;
				behavior: url(PIE.htc);
				margin: 3px;
				padding: 4px;
				width: 100px;
				
			}

			#cuadro{
				border-color: #ccc;
				border-style: solid;
				border-radius: 0.1em;
				margin: 2px;
				padding: 2px;
				width: 90%;
			}

			

	</style>
	<link rel="stylesheet" type="text/css" href="calendar.css" />
	<script src="jquery.js"></script>
	<script type="text/javascript" src="cal.js"></script>
	<script type="text/javascript">
		function validar(){
		    	
		    	if (document.form.sociedad.value == ''){
		    		alert("Es necesario que ingrese una Sociedad");
		    		return false;
		    	}

		    	if (document.form.fecinicial.value == '')
		    	{
		    		alert("Es necesario que ingrese una Fecha Inicial");
		    		return false;	
		    	}

		    	if (document.form.fecfinal.value == '')
		    	{
		    		alert("Es necesario que ingrese una Fecha Final");
		    		return false;	
		    	}
		    	/*
		    	if (confirm("Esta Seguro(a) de continuar?"))
				{
					return true;
				}
				else
				{
					return false;
				} 
				*/

		    	return true;
		    }
			
			$(document).ready(function() {
			   $('#fecdesde').simpleDatepicker();
			   $('#fechasta').simpleDatepicker();
			   //$("#datepicker").datepicker();
			});

			function llamar_cliente()
			{
				
				var str = "";
				var id = "";
				var accion = "Add";
				  $("#selector option:selected").each(function () {
				    str += $(this).text();
				    id = $(this).attr('value');
				    
				  });
				//alert(id); 
				if (id == "")
				{
					alert("Seleccione un Sociedad");
				}
				else{
					//alert ("Ha comenzado la creacion"+id);
					$("#llamar_cliente").show();
				    
				    var accion = "Add";
			    	$.post("llamar_clientes.php", {accion:accion, identificador:id}, function(datos)
						{
						//El div que muestra los datos impresos en php tiene id="formatos"
						$("#llamar_cliente").html(datos);
						});
				}
			}

			function llamar_nomusuario()
			{
				
				var str = "";
				var id = "";
				var accion = "Add";
				  $("#selector option:selected").each(function () {
				    str += $(this).text();
				    id = $(this).attr('value');
				    
				  });
				//alert(id); 
				if (id == "")
				{
					alert("Seleccione un Sociedad");
				}
				else{
					//alert ("Ha comenzado la creacion"+id);
					$("#llamar_cliente").show();
				    
				    var accion = "Add";
			    	$.post("llamar_nomusuario.php", {accion:accion, identificador:id}, function(datos)
						{
						//El div que muestra los datos impresos en php tiene id="formatos"
						$("#llamar_nomusuario").html(datos);
						});
				}
			}

	</script>

</head>
<body>
	
	<div align="center" id="buscador">

		<form id="formulario" name="form" method="get" action="" onsubmit="return validar();" accept-charset="UTF-8">
			<legend align="center">Busqueda de Pedidos
			<br/>
			<?= $compania ?>
			</legend>
			<div align="center" id="cuadro">
				<label>Sociedad</label>
				<select id="selector" name="sociedad" style="width:300px;" onChange="llamar_cliente();llamar_nomusuario();"> 
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
			</div>
			<div id="llamar_cliente" ></div>

			<div id="llamar_nomusuario" ></div>
			
			<div align="center" id="cuadro">
				<label>Fecha Inicial  </label>
				<!--input class="fecha" id="fecdesde" type="text" name="fecdesde" placeholder="yyyy-mm-dd" title="yyyy-mm-dd" value="<?= $fechadesde ?>"/>
				<br/-->
				
				<input size="14" id="fc_1295035967" type="text" READONLY name="fecinicial" title="yyyy-mm-dd" /> <!-- onChange="Ir_Siguiente()" onBlur="Ir_Siguiente()" --> 
				<a href="javascript:displayCalendarFor('fc_1295035967');"><img src="<?php echo $gloRutaPublica . "/imagenes/b_calendar.jpg"; ?>" border="0"></a>
				&nbsp; &nbsp;
				<label>Fecha Final  </label>

				<input size="14" id="fc_1295035968" type="text" READONLY name="fecfinal" title="yyyy-mm-dd" /> <!-- onChange="Ir_Siguiente()" onBlur="Ir_Siguiente()" --> 
				<a href="javascript:displayCalendarFor('fc_1295035968');"><img src="<?php echo $gloRutaPublica . "/imagenes/b_calendar.jpg"; ?>" border="0"></a>

			</div>

			<input type="hidden" value="lookup" name="accion" />
			<input type="submit" name="buscar" value="Buscar" id="opcion_"/>
			
		</form>

	</div>

	<div id="resultado">
	<?php
	/*
	echo "<br>pag: ".$_GET[pag];
	echo "<br>acc: ".$_GET[accion];
	echo "<br>soc: ".$_GET[sociedad];
	*/
	if($_GET[accion] == "lookup" && isset($_GET[sociedad]) || isset($_GET[pag]))
	{
		$_GET[accion] = "lookup";

		$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
		mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());
		
		$identificador = $_GET[sociedad];
		$fecinicial = $_GET[fecinicial];
		$fecfinal = $_GET[fecfinal];

		// maximo por pagina
		$limit = 10;
		// pagina pedida
		$pag = (int) $_GET["pag"];
		if ($pag < 1)
		{
		   $pag = 1;
		}
		$offset = ($pag-1) * $limit;

		$sql  = "SELECT SQL_CALC_FOUND_ROWS docentry, cardcode, cardname, docdate, j1.name as pozo1 FROM ordr as j0 ";
		$sql .= " Left Join pozoline as j1 on j0.pozo = j1.code ";
		$sql .= " Where j0.id_integra = '$identificador' and docdate between '$fecinicial' and '$fecfinal' ";
		//echo "".$sql;
		if (isset($_GET[cardcode]) && $_GET[cardcode] <> '')
		{
			$sql .= " And cardcode = '" .$_GET[cardcode]."' ";
		}
		if (isset($_GET[usuarioweb]) && $_GET[usuarioweb] <> '')
		{
			$sql .= " And usuarioweb = '" .$_GET[usuarioweb]."' ";
		}
		$sql .= " Order By docentry DESC";		
		$sql .= " LIMIT $offset, $limit";

		$sqlTotal = "SELECT FOUND_ROWS() as total";
		
		$rs = mysql_query($sql);
		$rsTotal = mysql_query($sqlTotal);

		$rowTotal = mysql_fetch_assoc($rsTotal);
		// Total de registros sin limit
		$total = $rowTotal["total"];

		?>
		<br/>
		<table align="center" width="75%" id="list3" class="tabla_s1">
		<?php
		if ($row = mysql_fetch_assoc($rs)){
		//if ($row=$result->FetchNextObj()){
			//$row-MoveFirst();
			?>

			<tr >
				<td align="center" class= "tabla_s1_td_t1">
					<b>Ver</b>			</td>
				<td align="center" class= "tabla_s1_td_t1">
					<b>Referencia</b>		</td>
				<td align="center" class= "tabla_s1_td_t1">	
					<b>Cardcode</b>		</td>
				<td align="center" class= "tabla_s1_td_t1">
					<b>Cardname</b>		</td>
				<td align="center" class= "tabla_s1_td_t1">
					<b>Fecha</b>		</td>
				<td align="center" class= "tabla_s1_td_t1">
					<b>Pozo</b>		</td>
			</tr>

			<?php

			do
			{
				?>
					<tr>
						<td align="center" width="5%" class="tabla_s1_td_c1">
	<a target="contenido" onclick="javascript:parent.frameInferior.location.href='mostrar_pedido.php?docentry=<?= $row[docentry]; ?>'">
	<img src="<? echo $gloRutaPublica . "/imagenes/ver_archivo.jpg"; ?>" width="16" height="16" alt="Ver" style="cursor:pointer" title="Ver">
	</a>
	<!-- onclick="javascript:parent.contenido.location.href='<?= "mostrar_formulario.php?docentry=".$row->id; ?>' return false" -->
						</td>
						<td align="center" width="10%" class="tabla_s1_td_c1">
							<?= $row[docentry]; ?>
						</td>
						<td align="center" width="10%" class="tabla_s1_td_c1">
							<?= $row[cardcode]; ?>
						</td>
						<td align="center" width="30%" class="tabla_s1_td_c1">
							<?= $row[cardname]; ?>
						</td>
						<td align="center" width="10%" class="tabla_s1_td_c1">
							<?= $row[docdate]; ?>
						</td>
						<td align="center" width="10%" class="tabla_s1_td_c1">
							<?= $row[pozo1]; ?>
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
		            $links[] = "<a href=\"?pag=$i&sociedad=$identificador&fecinicial=$fecinicial&fecfinal=$fecfinal\">$i</a>"; 
		         }
		         echo implode(" - ", $links);
		      ?>
		         </td>
		      </tr>
		   	</tfoot>
	   <?php
		}
		
		else{
			?>
			<tr>
				<td align="center">
					No hay Datos Concidentes
				</td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
	}
	?>
	</div>
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