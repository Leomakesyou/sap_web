<?php
	
if(!empty($_POST['dato'])) {
//echo "Resultados para: ".$_POST['dato']."<br />".$_POST['tipo']."-".$_POST['fila'];
search($_POST['dato'], $_POST['tipo'], $_POST['fila']);
} 
function search($valor, $tipo, $fila) {
	$valor = trim($valor);
	$fila = trim($fila);
include ("conexion/Conect_DB.php");
$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());
if ($valor == '*')
{
	$sql  = "SELECT j0.itemcode, j0.itemname, j1.pricelist, j1.price, j1.currency 
			 FROM oitm as j0
			 Inner Join itm1 as j1 on j0.itemcode = j1.itemcode	";
}
else{
	$sql  = "SELECT j0.itemcode, j0.itemname, j1.pricelist, j1.price, j1.currency 
			 FROM oitm as j0
			 Inner Join itm1 as j1 on j0.$tipo = j1.itemcode
			 WHERE j0.$tipo LIKE '%{$valor}%'";	
}

$sql .= " Order by $tipo";

$result = mysql_query($sql,$link) or die(mysql_error());	
$numDatos = @mysql_num_rows($result);

if ($numDatos > 0){
//	echo "<br/>Fila: ".$fila."<br/>";
?>
<select name="listbox" id="<?= $fila; ?>" size="5" ondblclick="LlevarValor(this.value,this.id);" width="300px"> 
<!-- LlevarValor -->
<?php
$j = 1;
	while($row = mysql_fetch_assoc($result))
	{
			?>
			<option value="<?= $row[itemcode].";".$row[itemname].";".$row[currency].";".$row[price] ?>"><?= $row[itemname] ?></option>
			<?php
	}
	?>
</select>
	<?php
}
else {
	echo "<br /><br /> No se han encontrado datos.";
}

}
?>

<html>
	<head>
		<script type="text/javascript" src="jquery.js"></script>
    	<script type="text/javascript">
    	function LlevarValor(valor, fila)
		{
		  	var arreglo = valor.split(';');
		  	$("#texto"+fila).val(arreglo[0]);
		  	$("#textoname"+fila).val(arreglo[1]);
		   	$("#quantity"+fila).val("1");
		   	$("#currency"+fila).val(arreglo[2]);
		   	$("#price"+fila).val(arreglo[3]);
		   	var total = $("#quantity"+fila).val() * arreglo[3];
		   	$("#linetotal"+fila).val(total);

		   	var list1 = "resultado"+fila;
		   	Cab=eval(list1);
		   	with (Cab.style) 
				display="none";
				
				var list2 = "celda"+fila;
			    Cab=eval(list2);
		    	with (Cab.style) 
					display="none";
			}
	</script>
	</head>
</html>